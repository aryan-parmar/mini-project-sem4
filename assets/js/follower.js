document.querySelectorAll('.follow').forEach((element)=> {
    element.addEventListener('click', (e) =>{
        element.classList.toggle('following');
        e.target.disabled = true;
        let url = "/follow/remove.php";
        let xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                if (xhr.responseText == 1){
                    e.target.innerHTML = "Removed";
                }
            }
        };
        xhr.send("id="+e.target.dataset.id+"&remove=unfollow");
    })
})
