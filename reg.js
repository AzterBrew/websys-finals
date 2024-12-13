
 // Get the select element and the input field
 const typeSelect = document.getElementById('type');
 const studentNumberInput = document.getElementById('student_number');
 const firstpass = document.getElementById('password');
 const confirmpass = document.getElementById('confirm_password');
 const passwarning = document.getElementById('passwarning');

 // Function to toggle the input field
 function toggleInput() {
    
     if (typeSelect.value === 'non_student') {
         studentNumberInput.disabled = true; // Disable input
         studentNumberInput.value = '';      // Clear the input value
         studentNumberInput.placeholder = "Not Applicable";

     } else {
         studentNumberInput.disabled = false; // Enable input
         studentNumberInput.placeholder = "Enter your student number";
     }
 }

 function confirmPass(){
    if(firstpass.value != confirmpass.value){
        console.log('not match')
        passwarning.style.visibility = 'visible';
    } else {
        console.log('match')
        passwarning.style.visibility = 'hidden';
    }
 }

 document.getElementById('passwarning').addEventListener('onkeyup', function () {
    confirmPass();
  });

 // Add event listener to the select element
 typeSelect.addEventListener('change', toggleInput);
//  confirmpass.addEventListener('change',confirmPass);

 // Call the function once to set the initial state
 toggleInput();
//  confirmPass();
