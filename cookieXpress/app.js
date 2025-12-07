// ======= 1. Inisialisasi Data User =======
if(!localStorage.getItem("userData")){
    const defaultUser = {
        username: "User",
        email: "user@gmail.com",
        password: "123456",
        profileImg: "imagecookie/default-profile.png",
        address: ""
    };
    localStorage.setItem("userData", JSON.stringify(defaultUser));
}

const userData = JSON.parse(localStorage.getItem("userData"));
// Commented out server-side save: this project uses PHP pages, avoid client-side POST to config.php
// saveUserToServer(userData);

// ======= 2. Fungsi Simpan Data =======
function saveUserData(){
    localStorage.setItem("userData", JSON.stringify(userData));
}

// ======= 3. Login / Signup =======
    if(document.getElementById("login-btn")){
        document.getElementById("login-btn").addEventListener("click", () => {
            const usernameInput = document.getElementById("username").value.trim();
            const passInput = document.getElementById("password").value;
            if(usernameInput === userData.username && passInput === userData.password){
                alert("Login Success!");
                window.location.href = "home.php"; // use server-side page
            } else {
                alert("Invalid username or password!");
            }
        });
    }

// ======= 4. Home Page =======
if(document.getElementById("welcome-msg")){
    document.getElementById("welcome-msg").innerText = `Hello ${userData.username}!`;
    // Profile picture (jika ada)
    const profileIcon = document.getElementById("profile-icon");
    if(profileIcon) profileIcon.src = userData.profileImg;
}

// ======= 5. Settings Page =======
if(document.getElementById("username-input")){
    // Inisialisasi
    document.getElementById("username-input").value = userData.username;
    document.getElementById("email-input").value = userData.email;
    document.getElementById("address-input").value = userData.address;
    document.getElementById("profile-img").src = userData.profileImg;

    // Upload foto
    document.getElementById("upload-photo").addEventListener("change", (e)=>{
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(event){
                document.getElementById("profile-img").src = event.target.result;
                userData.profileImg = event.target.result;
                saveUserData();
            }
            reader.readAsDataURL(file);
        }
    });

    // Save Username
    document.getElementById("save-username").addEventListener("click", ()=>{
        const newUsername = document.getElementById("username-input").value.trim();
        if(newUsername){
            userData.username = newUsername;
            saveUserData();
            alert("Username updated!");
        }
    });

    // Save Email
    document.getElementById("save-email").addEventListener("click", ()=>{
        const newEmail = document.getElementById("email-input").value.trim();
        userData.email = newEmail;
        saveUserData();
        alert("Email updated!");
    });

    // Save Password
    document.getElementById("save-pass").addEventListener("click", ()=>{
        const currentPass = document.getElementById("current-pass").value;
        const newPass = document.getElementById("new-pass").value;
        if(currentPass === userData.password){
            if(newPass.length >= 6){
                userData.password = newPass;
                saveUserData();
                alert("Password updated!");
                document.getElementById("current-pass").value = "";
                document.getElementById("new-pass").value = "";
            } else {
                alert("New password must be at least 6 characters!");
            }
        } else {
            alert("Current password is incorrect!");
        }
    });

    // Save Address
    document.getElementById("save-address").addEventListener("click", ()=>{
        const newAddress = document.getElementById("address-input").value.trim();
        userData.address = newAddress;
        saveUserData();
        alert("Address updated!");
    });
}

// ======= 6. Menu / Cart Page =======
if(document.querySelectorAll(".user-name")){
    document.querySelectorAll(".user-name").forEach(el=>{
        el.innerText = userData.username;
    });
}

if(document.getElementById("profile-img-menu")){
    document.getElementById("profile-img-menu").src = userData.profileImg;
}

if(document.getElementById("shipping-address")){
    document.getElementById("shipping-address").value = userData.address;
}

function saveUserToServer(userData){
    fetch("php/config.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(userData)
    })
    .then(res => res.json())
    .then(data => {
        if(data.status === "success"){
            alert("Data berhasil disimpan di server!");
        } else {
            alert("Error: " + data.message);
        }
    });
}