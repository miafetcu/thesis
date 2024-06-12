document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('msform');

    form.addEventListener('submit', async (event) => {
        event.preventDefault(); // Prevent the default form submission

        // Collect form data
        const formData = new FormData(form);

        try {
            // Send a POST request using Fetch API
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
            });

            if (response.ok) {
                const result = await response.json();
                // form.innerHTML=
                localStorage.setItem('formResult', JSON.stringify(result));
                console.log(result);
                var capcValue = document.getElementById('capc').value;
                
                result.capcValue = capcValue;
                    const queryParams = new URLSearchParams(result);
                    console.log(queryParams);
                    const queryString = queryParams.toString();
                    const url = `ACalculator.html?${queryString}`;
                
                // Redirect to another HTML page to display the result
                window.location.href = url;
                
                console.log('Success:', result);
            } else {
                const errorText = await response.text(); // Capture detailed error response
                        console.error('Error:', response.status, errorText);
            }
        } 
        catch (error) {
            console.error('Error:', error);
           
        }
    });
});


       




