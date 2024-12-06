<!-- resources/views/layouts/create-post-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat:400,600&display=swap');
        body {
            align-items: center;
            background: #D8AA96;
            color: rgba(0,0,0,.8);
            display: grid;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            font-weight: 400;
            height: 100vh;
            justify-items: center;
            width: 100vw;
        }

        .signup-container {
            display: grid;
            grid-template-areas: "left right";
            max-width: 900px;
        }

        .left-container {
            background: #807182;
            overflow: hidden;
            padding: 40px 0 0 0;
            position: relative;
            text-align: center;
            width: 300px;
        }

        .left-container h1 {
            color: rgba(0,0,0,.8);
            display: inline-block;
            font-size: 24px;
        }

        .left-container h1 i {
            background: #F7B1AB;
            border-radius: 50%;
            color: #807182;
            font-size: 24px;
            margin-right: 5px;
            padding: 10px;
            transform: rotate(-45deg);
        }

        .puppy {
            bottom: -5px;
            position: absolute;
            text-align: center;
        }

        .puppy:before {
            background: #807182;
            content: "";
            height: 100%;
            left: 0;
            opacity: .4;
            position: absolute;
            width: 100%;
            z-index: 1;
        }

        .puppy img {
            filter: sepia(100%);
            width: 70%;
        }

        .right-container {
            background: black; /* Changed background color to black */
            display: grid;
            grid-template-areas: "." ".";
            width: 500px;
        }

        .right-container h1:nth-of-type(1) {
            color: rgba(0,0,0,.8);
            font-size: 28px;
            font-weight: 600;
        }

        .set {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
        }

        input {
            border: 1px solid rgba(0,0,0,.1);
            border-radius: 4px;
            height: 38px;
            line-height: 38px;
            padding-left: 5px;
        }

        input, label {
            color: rgba(0,0,0,.8);
        }

        header {
            padding: 40px;
        }

        label, input, .pets-photo {
            width: 176px;
        }

        .pets-photo {
            align-items: center;
            display: grid;
            grid-template-areas: "." ".";
        }

        .pets-photo button {
            border: none;
            border-radius: 50%;
            height: 38px;
            margin-right: 10px;
            outline: none;
            width: 38px;
        }

        .pets-photo button i {
            color: rgba(0,0,0,.8);
            font-size: 16px;
        }

        .pets-weight .radio-container {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        footer {
            align-items: center;
            background: #fff;
            display: grid;
            padding: 5px 40px;
        }

        footer button {
            border: 1px solid rgba(0,0,0,.2);
            height: 38px;
            line-height: 38px;
            width: 100px;
            border-radius: 19px;
            font-family: 'Montserrat', sans-serif;
        }

        #back {
            background: #fff;
            transition: .2s all ease-in-out;
        }

        #back:hover {
            background: #171A2B;
            color: white;
        }

        #next {
            background: #807182;
            border: 1px solid transparent;
            color: #fff;
        }

        #next:hover {
            background: #171A2B;
        }

        .pets-name, .pets-breed, .pets-birthday, .pets-gender, .pets-spayed-neutered, .pets-weight {
            label {
                display: block;
                margin-bottom: 5px;
            }
        }

        .radio-container {
            background: #fff;
            border: 1px solid rgba(0,0,0,.1);
            border-radius: 4px;
            display: inline-block;
            padding: 5px;
        }

        .radio-container label {
            background: transparent;
            border: 1px solid transparent;
            border-radius: 2px;
            display: inline-block;
            height: 26px;
            line-height: 26px;
            margin: 0;
            padding: 0;
            text-align: center;
            transition: .2s all ease-in-out;
            width: 80px;
        }

        .radio-container input[type="radio"] {
            display: none;
        }

        .radio-container input[type="radio"]:checked + label {
            background: #F7B1AB;
            border: 1px solid rgba(0,0,0,.1);
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="left-container">
            <h1>
                <i class="fas fa-paw"></i>
                PUPASSURE
            </h1>
            <div class="puppy">
                <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/38816/image-from-rawpixel-id-542207-jpeg.png" alt="Puppy">
            </div>
        </div>
        <div class="right-container">
            <header>
                <h1>Make a fortune by selling your sheeits!</h1>
                <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" x-data="formSubmit" @submit.prevent="submit">
                    @csrf
                    <div class="set">
                        <div class="pets-name">
                            <label for="title">Post Description</label>
                            <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="post description" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl @error('title') ring-red-500 @enderror">
                            @error('title')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pets-photo">
                            <button id="pets-upload" type="button">
                                <i class="fas fa-camera-retro"></i>
                            </button>
                            <label for="image">Upload a photo</label>
                            <input type="file" name="image" id="image" class="hidden">
                            @error('image')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="set">
                        <div class="pets-breed">
                            <label for="location">Location</label>
                            <input id="location" type="text" name="location" value="{{ old('location') }}" placeholder="Location" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl @error('location') ring-red-500 @enderror">
                            @error('location')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pets-birthday">
                            <label for="price">Price</label>
                            <input id="price" type="text" name="price" value="{{ old('price') }}" placeholder="price" class="border w-full text-base px-2 py-2 focus:outline-none focus:ring-0 focus:border-gray-600 rounded-2xl @error('price') ring-red-500 @enderror">
                            @error('price')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="set">
                        <div class="pets-weight">
                            <label for="category">Category</label>
                            <div class="radio-container">
                                <input id="category-paper" name="category" type="radio" value="Paper" {{ old('category') == 'Paper' ? 'checked' : '' }}>
                                <label for="category-paper">Paper</label>
                                <input id="category-plastics" name="category" type="radio" value="Plastic" {{ old('category') == 'Plastic' ? 'checked' : '' }}>
                                <label for="category-plastics">Plastics</label>
                                <input id="category-metals" name="category" type="radio" value="Metal" {{ old('category') == 'Metal' ? 'checked' : '' }}>
                                <label for="category-metals">Metals</label>
                            </div>
                            @error('category')
                            <p class="error">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <footer>
                        <div class="set">
                            <button id="next" type="submit">Submit</button>
                        </div>
                    </footer>
                </form>
            </header>
        </div>
    </div>
</body>
</html> 