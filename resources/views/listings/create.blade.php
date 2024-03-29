<x-layout>
  <x-card class="p-10 max-w-lg mx-auto mt-24">
    <header class="text-center">
      <h2 class="text-2xl font-bold uppercase mb-1">Create a Job</h2>
      <p class="mb-4">Post a Job to find a developer</p>
    </header>

    <form method="POST" action="{{ route('listings.store') }}" enctype="multipart/form-data">

      @csrf
      <div class="mb-6">
        <label for="company" class="inline-block text-lg mb-2">Company Name</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="company"
          value="{{old('company')}}" />

        @error('company')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="title" class="inline-block text-lg mb-2">Job Title</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="title"
          placeholder="Example: Senior Laravel Developer" value="{{old('title')}}" />

        @error('title')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="location" class="inline-block text-lg mb-2">Job Location</label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="location"
          placeholder="Example: Remote, Boston MA, etc" value="{{old('location')}}" />

        @error('location')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="email" class="inline-block text-lg mb-2">
          Contact Email
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="email" value="{{old('email')}}" />

        @error('email')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="website" class="inline-block text-lg mb-2">
          Website/Application URL
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="website"
          value="{{old('website')}}" />

        @error('website')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="tags" class="inline-block text-lg mb-2">
          Tags (Comma Separated)
        </label>
        <input type="text" class="border border-gray-200 rounded p-2 w-full" name="tags"
          placeholder="Example: Laravel, Backend, Postgres, etc" value="{{old('tags')}}" />

        @error('tags')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>
					<div class="mb-6">
	  <label for="logo" class="inline-block text-lg mb-2">
		Company Logo
	  </label>
	  <div>
		<input type="radio" id="use_camera" name="logo_input_option" value="camera" checked />
		<label for="use_camera">Use Camera</label>
		<input type="radio" id="select_file" name="logo_input_option" value="file" />
		<label for="select_file">Select File</label>
	  </div>
	  <input type="file" id="logo_file" class="border border-gray-200 rounded p-2 w-full hidden" name="logo" accept="image/*" />
	  <div id="logo_camera" class="border border-gray-200 rounded p-2 w-full">
		<video id="camera_preview" class="w-full" autoplay playsinline></video>
		<button id="capture_image" type="button">Capture Image</button>
	    <img id="display_captured_image" class="hidden mt-4" />

	  </div>
	  
			  

	  <canvas id="captured_image" class="hidden"></canvas>
	  <input type="hidden" id="captured_data" name="logo_base64" />
	  <input type="hidden" id="captured_data" name="logo_data">

	  @error('logo')
	  <p class="text-red-500 text-xs mt-1">{{$message}}</p>
	  @enderror
	</div>



      <div class="mb-6">
        <label for="description" class="inline-block text-lg mb-2">
          Job Description
        </label>
        <textarea class="border border-gray-200 rounded p-2 w-full" name="description" rows="10"
          placeholder="Include tasks, requirements, salary, etc">{{old('description')}}</textarea>

        @error('description')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
      </div>

      <div class="mb-6">
        <button class="bg-laravel text-white rounded py-2 px-4 hover:bg-black">
          Create Job
        </button>

        <a href="/~2120687/hunt/public" class="text-black ml-4"> Back </a>
      </div>
    </form>
  </x-card>
</x-layout>>


<script>
  const useCamera = document.getElementById('use_camera');
  const selectFile = document.getElementById('select_file');
  const logoFile = document.getElementById('logo_file');
  const logoCamera = document.getElementById('logo_camera');
  const cameraPreview = document.getElementById('camera_preview');
  const captureImageBtn = document.getElementById('capture_image');
  const capturedImage = document.getElementById('captured_image');
  const capturedData = document.getElementById('captured_data');
  
  let stream;

  async function initCamera() {
    try {
      stream = await navigator.mediaDevices.getUserMedia({ video: true });
      cameraPreview.srcObject = stream;
    } catch (err) {
      console.error('Error accessing camera:', err);
      alert('Error accessing camera. Please check if your camera is connected and try again.');
    }
  }

  useCamera.addEventListener('change', () => {
    logoCamera.classList.remove('hidden');
    logoFile.classList.add('hidden');
    initCamera();
  });

  selectFile.addEventListener('change', () => {
    logoFile.classList.remove('hidden');
    logoCamera.classList.add('hidden');
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
    }
  });

 
  const displayCapturedImage = document.getElementById('display_captured_image');

  captureImageBtn.addEventListener('click', () => {
    const ctx = capturedImage.getContext('2d');
    capturedImage.width = cameraPreview.videoWidth;
    capturedImage.height = cameraPreview.videoHeight;
    ctx.drawImage(cameraPreview, 0, 0);
    const imageDataUrl = capturedImage.toDataURL('image/png');
	capturedData.value = imageDataUrl.replace(/^data:image\/(png|jpg|jpeg);base64,/, '');

    // Display the captured image
    displayCapturedImage.src = imageDataUrl;
    displayCapturedImage.classList.remove('hidden');
  });

  initCamera();
</script>

