<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class InventoryHistoryController extends Controller
{
    /**
     * Get inventory history for the authenticated user
     */
    public function getHistory(Request $request)
    {
        try {
            // Check if the table exists
            if (!Schema::hasTable('inventory_histories')) {
                return response()->json([
                    'success' => false,
                    'error' => 'Table not found',
                    'message' => 'The inventory history table does not exist. Please run migrations.',
                    'missing_table' => true
                ], 404);
            }
                
            $postIds = Post::where('user_id', Auth::id())->pluck('id')->toArray();
            
            // If no products found, return empty result
            if (empty($postIds)) {
                return response()->json([
                    'success' => true,
                    'history' => [
                        'data' => [],
                        'current_page' => 1,
                        'last_page' => 1,
                    ],
                    'products' => []
                ]);
            }
            
            // Filter by product if specified
            $productId = $request->input('product_id');
            $query = InventoryHistory::with(['post', 'user'])->whereIn('post_id', $postIds);
            
            if ($productId) {
                $query->where('post_id', $productId);
            }
            
            // Filter by action type if specified
            $action = $request->input('action');
            if ($action && $action !== 'all') {
                $query->where('action', $action);
            }
            
            // Filter by field if specified
            $field = $request->input('field');
            if ($field && $field !== 'all') {
                $query->where('field_name', $field);
            }
            
            // Order by most recent changes
            $history = $query->orderBy('created_at', 'desc')->paginate(10);
            
            // For select dropdowns in the UI
            $products = Post::whereIn('id', $postIds)->get(['id', 'title']);
            
            return response()->json([
                'success' => true,
                'history' => $history,
                'products' => $products
            ]);
        } catch (\Exception $e) {
            // Better error logging with table check
            $errorMessage = $e->getMessage();
            if (str_contains($errorMessage, "inventory_histories' doesn't exist") || 
                str_contains($errorMessage, "table not found")) {
                
                \Log::error('Inventory history table does not exist: ' . $errorMessage);
                return response()->json([
                    'success' => false,
                    'error' => 'Table not found',
                    'message' => 'The inventory history table does not exist. Please run migrations.',
                    'missing_table' => true
                ], 404);
            }
            
            \Log::error('Error fetching inventory history: ' . $errorMessage);
            return response()->json([
                'success' => false,
                'error' => 'Server error occurred',
                'message' => $errorMessage
            ], 500);
        }
    }
    
    /**
     * Log a history entry
     */
    public static function logHistory($postId, $action, $fieldName, $oldValue, $newValue, $notes = null)
    {
        try {
            InventoryHistory::create([
                'post_id' => $postId,
                'user_id' => Auth::id(),
                'action' => $action,
                'field_name' => $fieldName,
                'old_value' => $oldValue,
                'new_value' => $newValue,
                'notes' => $notes
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Error logging inventory history: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Export inventory data
     */
    public function exportInventory(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'format' => 'required|string|in:csv,excel,pdf',
                'type' => 'required|string|in:current,history'
            ]);

            $format = $request->input('format');
            $type = $request->input('type');
            
            // Get user's product IDs
            $postIds = Post::where('user_id', Auth::id())->pluck('id')->toArray();
            
            if (empty($postIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No products found to export'
                ], 404);
            }
            
            // Determine what data to export
            if ($type === 'current') {
                // Export current inventory
                $data = $this->getCurrentInventoryData($postIds);
                $filename = 'inventory_' . date('Y-m-d') . '.' . $format;
            } else {
                // Export history
                $data = $this->getHistoryData($postIds);
                $filename = 'inventory_history_' . date('Y-m-d') . '.' . $format;
            }
            
            // Generate the export based on format
            return $this->generateExport($data, $format, $filename, $type);
            
        } catch (\Exception $e) {
            \Log::error('Error exporting inventory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Export failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get current inventory data for export
     */
    private function getCurrentInventoryData($postIds)
    {
        $posts = Post::whereIn('id', $postIds)
            ->select('id', 'title', 'category', 'quantity', 'price', 'unit', 'location')
            ->get();
            
        $data = [];
        
        // Structure data for export
        foreach ($posts as $post) {
            $data[] = [
                'ID' => $post->id,
                'Product' => $post->title,
                'Category' => $post->category,
                'Quantity' => $post->quantity,
                'Unit' => $post->unit,
                'Price' => $post->price,
                'Value' => $post->quantity * $post->price,
                'Location' => $post->location
            ];
        }
        
        return $data;
    }
    
    /**
     * Get history data for export
     */
    private function getHistoryData($postIds)
    {
        $history = InventoryHistory::whereIn('post_id', $postIds)
            ->with('post:id,title')
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $data = [];
        
        // Structure data for export
        foreach ($history as $record) {
            $data[] = [
                'Date' => $record->created_at->format('Y-m-d H:i:s'),
                'Product' => $record->post->title ?? 'Unknown Product',
                'Action' => ucfirst($record->action),
                'Field' => ucfirst($record->field_name),
                'Old Value' => $record->old_value,
                'New Value' => $record->new_value,
                'User' => $record->user->name ?? 'Unknown User',
                'Notes' => $record->notes
            ];
        }
        
        return $data;
    }
    
    /**
     * Generate the export file in the requested format
     */
    private function generateExport($data, $format, $filename, $type)
    {
        switch ($format) {
            case 'csv':
                return $this->generateCsv($data, $filename);
                
            case 'excel':
                return $this->generateExcel($data, $filename, $type);
                
            case 'pdf':
                return $this->generatePdf($data, $filename, $type);
                
            default:
                throw new \Exception('Unsupported export format');
        }
    }
    
    /**
     * Generate CSV export
     */
    private function generateCsv($data, $filename)
    {
        if (empty($data)) {
            return response()->json(['success' => false, 'message' => 'No data to export'], 404);
        }
        
        $headers = array_keys($data[0]);
        
        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to fix Excel encoding issues
            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
            
            // Add headers
            fputcsv($file, $headers);
            
            // Add data rows
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'max-age=0'
        ]);
    }
    
    /**
     * Generate Excel export (simplified version)
     */
    private function generateExcel($data, $filename, $type)
    {
        // In a real implementation, you'd use a library like PhpSpreadsheet
        // For this example, we'll use CSV with an .xlsx extension which will open in Excel
        $filename = str_replace('.excel', '.xlsx', $filename);
        return $this->generateCsv($data, $filename);
    }
    
    /**
     * Generate PDF export (simplified version)
     */
    private function generatePdf($data, $filename, $type)
    {
        // In a real implementation, you'd use a library like TCPDF, FPDF, or Dompdf
        // For this example, we'll create a simple HTML table and convert to PDF
        $title = ($type === 'current') ? 'Current Inventory' : 'Inventory History';
        
        $html = '<html><head><title>' . $title . '</title>';
        $html .= '<style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #517A5B; color: white; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            h1 { color: #517A5B; }
            .footer { margin-top: 20px; font-size: 10px; color: #666; text-align: center; }
        </style></head>';
        
        $html .= '<body><h1>' . $title . ' - ' . date('Y-m-d') . '</h1>';
        $html .= '<table><thead><tr>';
        
        // Add headers
        if (!empty($data)) {
            foreach (array_keys($data[0]) as $header) {
                $html .= '<th>' . htmlspecialchars($header) . '</th>';
            }
        }
        
        $html .= '</tr></thead><tbody>';
        
        // Add data rows
        foreach ($data as $row) {
            $html .= '<tr>';
            foreach ($row as $value) {
                $html .= '<td>' . htmlspecialchars($value) . '</td>';
            }
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '<div class="footer">Generated by Recyclo on ' . date('Y-m-d H:i:s') . '</div>';
        $html .= '</body></html>';
        
        // Use Dompdf to convert HTML to PDF
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        return $dompdf->stream($filename, [
            'Attachment' => true
        ]);
    }
}
