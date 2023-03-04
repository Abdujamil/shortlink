const shortLinkForm =  document.getElementById('short_link_form');
const inputLink = document.getElementById('short_link_value');
const error = document.getElementById('error');
const btnSubmit = document.getElementById('btn_submit');
const shortLinkNonce = document.getElementById('short_link_nonce');
const loader = document.getElementById('preloader');

shortLinkForm.addEventListener('submit', (e) =>{
    e.preventDefault();

    let formData = new FormData();
    formData.append('action', 'short_link_generate');
    formData.append('url', document.getElementById('short_link_value').value);
    formData.append('_ajax_nonce', document.getElementById('short_link_nonce').value);

    fetch(shortlink_scripts_data.admin_ajax_url, {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(response => {
            if(!inputLink.value){
                setTimeout(()=>{
                    loader.style.display = "none";
                    inputLink.classList = "error";
                    error.innerHTML = response.data;
                    console.log(response.data);
                }, 1500);
                    loader.style.display = "block";
                console.log(response);
            }
            else {
                    setTimeout(()=>{
                        error.innerHTML = "";
                        inputLink.classList = "form-field";
                        loader.style.display = "none";
                        inputLink.value = response.data;

                            if(!shortLinkNonce.value) {
                                btnSubmit.disabled = false;

                            } else {
                                btnSubmit.classList.toggle('disabled');
                                btnSubmit.disabled = true;
                            }
                        console.log(response.data)
                    }, 1000);
                    loader.style.display = "block";
            }
        })
        .catch(err => console.log(err))
})

// inputLink.addEventListener('change', (e) => {
//     if(e.target.value === ""){
//         btnSubmit.disabled = false;
//     } else {
//         btnSubmit.disabled = true;
//     }
// });
