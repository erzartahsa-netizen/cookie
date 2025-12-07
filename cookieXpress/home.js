// Safely update UI with userData when elements exist
const userData = JSON.parse(localStorage.getItem("userData")) || { username: "User" };

const welcomeMsg = document.getElementById("welcome-msg");
if(welcomeMsg){
    welcomeMsg.innerText = `Hello ${userData.username}!`;

    window.addEventListener("storage", (e) => {
        if(e.key === "userData"){
            const updatedUserData = JSON.parse(e.newValue);
            if(welcomeMsg) welcomeMsg.innerText = `Hello ${updatedUserData.username}!`;
        }
    });
}

const profileBtn = document.getElementById("profile-btn");
if(profileBtn){
    profileBtn.addEventListener("click", () => {
        window.location.href = "setting.php";
    });
}

const menuBtn = document.getElementById("menu-btn");
if(menuBtn){
    menuBtn.addEventListener("click", () => {
        window.location.href = "menu.php";
    });
}
