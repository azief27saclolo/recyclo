public class StudentInfoMultiThread implements Runnable {
    private int threadId;
    private static final String FULL_NAME = "Azief Saclolo"; // Replace with your name
    private static final String COURSE = "Bachelor of Science in Computer Science"; // Replace with your course
    private static final String YEAR = "3rd Year"; // Replace with your year
    private static final String SECTION = "Section C"; // Replace with your section

    public StudentInfoMultiThread(int threadId) {
        this.threadId = threadId;
    }

    @Override
    public void run() {
        switch (threadId) {
            case 1:
                System.out.println("Thread " + threadId + " - Full Name: " + FULL_NAME);
                break;
            case 2:
                System.out.println("Thread " + threadId + " - Course: " + COURSE);
                break;
            case 3:
                System.out.println("Thread " + threadId + " - Year: " + YEAR);
                break;
            case 4:
                System.out.println("Thread " + threadId + " - Section: " + SECTION);
                break;
            default:
                System.out.println("Invalid thread ID");
        }
    }

    public static void main(String[] args) {
        // Create four runnable objects
        StudentInfoMultiThread task1 = new StudentInfoMultiThread(1);
        StudentInfoMultiThread task2 = new StudentInfoMultiThread(2);
        StudentInfoMultiThread task3 = new StudentInfoMultiThread(3);
        StudentInfoMultiThread task4 = new StudentInfoMultiThread(4);

        // Create four threads
        Thread thread1 = new Thread(task1);
        Thread thread2 = new Thread(task2);
        Thread thread3 = new Thread(task3);
        Thread thread4 = new Thread(task4);

        // Start all four threads
        thread1.start();
        thread2.start();
        thread3.start();
        thread4.start();

        System.out.println("All threads have been started");
    }
}
