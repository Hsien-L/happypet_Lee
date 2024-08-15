let uid = 101;

function showModal(mymypetdata) {

    mymypetdata.forEach(element => {
        console.log(element.pet_variety);
        // console.log(element.pet_headphoto);
        
        formMyPet.innerHTML =`

        `});
    
}

function catch_pet_info() {

    fetch(`http://localhost/happypet_Lee/happypet_back/public/api/member_mypet`, {
        method: 'post',
        body: JSON.stringify({ uid: uid }),
        headers: { 'Content-Type': 'application/json' }

    })
        .then(response => response.json())
        .then(mypetdata => {
            console.log(mypetdata);
            // showModal(mypetdata)
        })
}

catch_pet_info()