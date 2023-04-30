document.querySelectorAll(".profile_edit").forEach((element) => {
  element.addEventListener("click", (e) => {
    e.target.disabled = true;
    if (e.target.dataset.follow == 0) {
      let url = "/follow/follow.php";
      let xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          if (xhr.responseText == 1) {
            e.target.innerHTML = "Pending";
          } else {
            e.target.innerHTML = "Followed";
          }
          e.target.dataset.follow = 1;
          e.target.disabled = false;
        }
      };
      // let data = JSON.stringify(obj);
      xhr.send("id=" + e.target.dataset.id + "&follow=follow");
    }
    if (e.target.dataset.follow == 1) {
      let url = "/follow/unfollow.php";
      let xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          if (xhr.responseText == 1) {
            e.target.innerHTML = "Follow";
          }
          e.target.dataset.follow = 0;
          e.target.disabled = false;
        }
      };
      xhr.send("id=" + e.target.dataset.id + "&unfollow=unfollow");
    }
  });
});

document.querySelectorAll(".post_delete").forEach((element) => {
  element.addEventListener("click", (e) => {
    e.target.disabled = true;
    let url = "/post/delete.php";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if (xhr.responseText == 1) {
          window.location.reload();
        }
      }
    };
    xhr.send("id=" + e.target.dataset.id + "&delete=delete");
  });
});

document.querySelectorAll(".post_report").forEach((element) => {
  element.addEventListener("click", (e) => {
    e.target.disabled = true;
    let url = "/post/report.php";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        if (xhr.responseText == 1) {
          alert("Reported");
        }
      }
    };
    xhr.send("id=" + e.target.dataset.id + "&report=report");
  });
});
window.addEventListener("load", () => {
  var profile_bio = document.querySelector(".profile_bio");
  console.log(profile_bio.innerText);
  re = /(?:https?|ftp):\/\/[\w/\-?=%.]+\.[\w/\-&?=%.]+/g;
  match = re.exec(profile_bio.innerText)
  console.log(match);
  match.forEach((element) => {
    console.log(element);
    profile_bio.innerHTML = profile_bio.innerHTML.replace(element, "<a href='" + element + "' target='_blank'>" + element + "</a>");
  });
});
