// Ambil elemen upload photo (guarded)
const uploadPhoto = document.getElementById("upload-photo");

// Ambil data user dari localStorage
let userData = JSON.parse(localStorage.getItem("userData")) || {
    username: localStorage.getItem("username") || "User",
    email: localStorage.getItem("email") || "",
    password: localStorage.getItem("password") || "123456",
    address: localStorage.getItem("address") || "",
    profileImg: localStorage.getItem("profileImg") || "imagecookie/default-profile.png"
};

// Inisialisasi tampilan (guard access)
if(document.getElementById("username-input")){
    document.getElementById("username-input").value = userData.username;
}
if(document.getElementById("email-input")){
    document.getElementById("email-input").value = userData.email;
}
if(document.getElementById("address-input")){
    document.getElementById("address-input").value = userData.address;
}
if(document.getElementById("profile-img")){
    document.getElementById("profile-img").src = userData.profileImg;
}

// Upload foto (guarded)
if(uploadPhoto){
    uploadPhoto.addEventListener("change", (e)=>{
        const file = e.target.files[0];
        if(file){
            const reader = new FileReader();
            reader.onload = function(){
                const profileImgEl = document.getElementById("profile-img");
                if(profileImgEl) profileImgEl.src = reader.result;
                userData.profileImg = reader.result;
                localStorage.setItem("userData", JSON.stringify(userData));
                alert("Profile photo updated!");
            }
            reader.readAsDataURL(file);
        }
    });
}

// ---------------- SAVE USERNAME ----------------
if(document.getElementById("save-username")){
    document.getElementById("save-username").addEventListener("click", ()=>{
        const newUsername = (document.getElementById("username-input") || {}).value || '';
        if(newUsername.trim() === ""){
            alert("Username cannot be empty!");
            return;
        }
        userData.username = newUsername.trim();
        localStorage.setItem("userData", JSON.stringify(userData));
        alert("Username succesfully updated!");
    });
}

// ---------------- SAVE EMAIL & PASSWORD ----------------
if(document.getElementById("save-email-pass")){
    document.getElementById("save-email-pass").addEventListener("click", ()=>{
        const newEmail = (document.getElementById("email-input") || {}).value || '';
        const currentPass = (document.getElementById("current-pass-email") || {}).value || '';

        if(newEmail.trim() === ""){
            alert("Email cannot be empty!");
            return;
        }

        if(currentPass !== userData.password){
            alert("Wrong Password!");
            return;
        }

        const newPassword = prompt("Masukkan password baru (biarkan kosong jika tidak ingin mengubah)");
        if(newPassword && newPassword.length >= 6){
            userData.password = newPassword;
        } else if(newPassword){
            alert("New Password Must Be 6 Letters!");
            return;
        }

        userData.email = newEmail.trim();
        localStorage.setItem("userData", JSON.stringify(userData));
        alert("Email and password succesfully updated!");
    });
}

// ---------------- SAVE ALAMAT ----------------
if(document.getElementById("save-address")){
    document.getElementById("save-address").addEventListener("click", ()=>{
        const newAddress = (document.getElementById("address-input") || {}).value || '';
        if(newAddress.trim() === ""){
            alert("Address cannot be empty!");
            return;
        }
        userData.address = newAddress.trim();
        localStorage.setItem("userData", JSON.stringify(userData));
        alert("Address succesfully updated!");
    });
}

// ---------------- LOAD DATA AWAL ----------------
window.addEventListener("load", ()=>{
    document.getElementById("username-input").value = userData.username;
    document.getElementById("email-input").value = userData.email;
    document.getElementById("address-input").value = userData.address;
    document.getElementById("profile-img").src = userData.profileImg;
});

// ---------------- BACK TO HOME ----------------
document.addEventListener("DOMContentLoaded", ()=>{
    const backBtn = document.getElementById("back-home-btn");
    if(backBtn){
        backBtn.addEventListener("click", ()=>{
            window.location.href = "home.php"; // navigate to server-side page
        });
    }
});

function updateUsername(){
    const username = document.getElementById('username-input').value;

    fetch('update_settings.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `type=username&username=${encodeURIComponent(username)}`
    })
    .then(res => res.text())
    .then(alert)
    .catch(console.error);
}

function updateEmailPass(){
    const email = document.getElementById('email-input').value;
    const currentPass = document.getElementById('current-pass-email').value;
    const newPass = prompt("Enter new password:");

    if(!newPass) return;

    fetch('update_settings.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `type=emailpass&email=${encodeURIComponent(email)}&current_password=${encodeURIComponent(currentPass)}&new_password=${encodeURIComponent(newPass)}`
    })
    .then(res => res.text())
    .then(alert)
    .catch(console.error);
}


