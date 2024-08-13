btnRegister.onclick = (event) => {
    event.preventDefault();
    let formData = new FormData(document.getElementById('myregister'));
    fetch('http://localhost/happypet/happypet_back/public/api/member_register', {
        method: 'post',
        body: formData
    })
        .then(response => {
            console.log(response);
            if (!response.ok) {
                throw new Error(`伺服器錯誤(fetch回傳有問題): ${response.statusText}`);
            }
            // return response.text()
            return response.json()
        })
        .then((data) => {
            console.log('我是data1', data.message)
            if (data.message){
                showModel( data.message)
            }else{
                showModel( data.error)
            }
            // alert_message.innerText = data.message;
        })


        function showModel(message){
            $('#myModal').modal('show')
            alert_message.innerText = message;
        }
    }

