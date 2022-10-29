let toggle = document.querySelector('.toggle');
let navigation = document.querySelector('.navigation');
let main = document.querySelector('.main');

toggle.onclick = function() {
    navigation.classList.toggle('active');
    main.classList.toggle('active');
}

//add hovered class in selected list item
let list = document.querySelectorAll('.navigation li');
function activeLink(){
    list.forEach((item) => item.classList.remove('hovered'));
    this.classList.add('hovered');
}

list.forEach((item) => item.addEventListener('mouseover', activeLink))

$(document).ready(function(){
    $("#btn-select-thumbnail").on('click',function(){
        $('input.file-thumbnail[type="file"]').trigger('click');

    });

    $('input.file-thumbnail[type="file"]').on('change',function(e) {
        let imgPreview = document.querySelector(".img-thumbnail");
        imgPreview.src = URL.createObjectURL(e.target.files[0]);
        imgPreview.onload = function() {
            URL.revokeObjectURL(imgPreview.src) // free memory
        }
    });

    $("#btn-select-cover").on('click',function(){
        $('input.file-cover[type="file"]').trigger('click');

    });

    $('input.file-cover[type="file"]').on('change',function(e) {
        let imgPreview = document.querySelector(".img-cover");
        imgPreview.src = URL.createObjectURL(e.target.files[0]);
        imgPreview.onload = function() {
            URL.revokeObjectURL(imgPreview.src) // free memory
        }
    });
});
