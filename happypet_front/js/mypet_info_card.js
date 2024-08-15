
// let uid = localStorage.getItem('uid');
let uid = 101;

function show(mymypetdata) {

    mypet_card.innerHTML = ''; //清空，重新生成

    // <div class="col">
    //     <div class="card h-100">
    //         <img src="../img/10_member/pet-money.jpg" class="card-img-top" alt="..."/>
    //             <div class="card-body">
    //                 <h5 class="card-title" id="mypet_name">Money</h5>
    //                 <p class="card-text">品種：柴犬</p>
    //                 <p class="card-text">生日：2020/08/01</p>
    //             </div>
    //             <div class="card-footer d-flex justify-content-center gap-2">
    //                 <button class="btn btn-secondary btn-sm">查看詳情</button>
    //                 <button class="btn btn-secondary btn-sm">編輯</button>
    //             </div>
    //     </div>
    // </div>

    mymypetdata.forEach(element => {
        console.log(element.pet_variety);
        // console.log(element.pet_headphoto);
        
        mypet_card.innerHTML += `
            <div class="col">
                <div class="card h-100">
                    <img src="../../happypet_back/storage/app/public/${element.pet_headphoto}" class="card-img-top" alt="..."/>
                    <div class="card-body">
                        <h5 class="card-title">${element.pet_name}</h5>
                        <p class="card-text">品種：${element.pet_variety}</p>
                        <p class="card-text">生日：${element.pet_birthday}</p>  
                    </div>
                    <div class="card-footer d-flex justify-content-center gap-2">
                        <button class="btn btn-secondary btn-sm" data-pid="${element.pid}" onclick="showModal(this)">查看詳情</button>
                        <button class="btn btn-secondary btn-sm">編輯</button>
                    </div>
                </div>
            </div>`

    });

    mypet_card.innerHTML += `<a data-bs-toggle="modal" data-bs-target="#addPetModal" href="#" class="card-add">
                            <div class="col card h-100">
                                <i class="bi bi-plus-circle-dotted"></i>
                                <div class="card-body mt-5">
                                    <h5 class="card-title mt-2">Add</h5>
                                    <p class="card-text">點此新增</p>
                                </div>
                                <div class="card-footer d-flex justify-content-center gap-2">
                                    <button class="btn btn-secondary btn-sm">新增寵物</button>
                                </div>
                            </div>
                        </a>`

}

function mypet_info_card() {

    fetch(`http://localhost/happypet_Lee/happypet_back/public/api/member_mypet`, {
        method: 'post',
        body: JSON.stringify({ uid: uid }),
        headers: { 'Content-Type': 'application/json' }

    })
        .then(response => response.json())
        .then(mypetdata => {
            console.log(mypetdata);
            show(mypetdata)
        })
}

mypet_info_card()

