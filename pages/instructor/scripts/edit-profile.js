// Select elements
const imageUploadInput = document.getElementById('image-upload');
const profileImage = document.querySelector('.img img');

// Handle image upload
imageUploadInput.addEventListener('change', (event) => {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = () => {
      profileImage.src = reader.result; 
    };
    reader.readAsDataURL(file);
  }
});
