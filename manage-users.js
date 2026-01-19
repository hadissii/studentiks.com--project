function loadUsers() {
    fetch("get_all_users.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "error") {
                alert(data.message);
                if (data.message.includes("Access denied") || data.message.includes("Not logged in")) {
                    window.location.href = "login.html";
                }
                return;
            }
            
            const tbody = document.querySelector("#users-table tbody");
            tbody.innerHTML = "";

            if (data.users && data.users.length > 0) {
                data.users.forEach(user => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name || 'N/A'}</td>
                            <td>${user.email || 'N/A'}</td>
                            <td>${user.phone || 'N/A'}</td>
                            <td>${user.role || 'user'}</td>
                            <td>
                                <button class="action-btn edit-btn" onclick="openEdit(${user.id}, '${(user.name || '').replace(/'/g, "\\'")}', '${(user.email || '').replace(/'/g, "\\'")}', '${(user.phone || '').replace(/'/g, "\\'")}', '${user.role || 'user'}')">Edit</button>
                                <button class="action-btn delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tbody.innerHTML = "<tr><td colspan='6' style='text-align: center;'>No users found</td></tr>";
            }
        })
        .catch(err => {
            console.error("Error loading users:", err);
            alert("Error loading users. Please try again.");
        });
}

// Check authentication on page load
document.addEventListener("DOMContentLoaded", () => {
    fetch("get_user.php")
        .then(res => res.json())
        .then(data => {
            if (data.status === "error" || data.role !== "admin") {
                alert("Access denied. Admin only.");
                window.location.href = "login.html";
            } else {
                loadUsers();
            }
        })
        .catch(err => {
            console.error("Auth check error:", err);
            window.location.href = "login.html";
        });
});

function deleteUser(id) {
    if (!confirm("Are you sure you want to delete this user?")) return;

    fetch("delete_user.php?id=" + id)
        .then(() => loadUsers());
}

let currentId = null;

function openEdit(id, name, email, phone, role) {
    currentId = id;
    document.getElementById("editName").value = name;
    document.getElementById("editEmail").value = email;
    document.getElementById("editPhone").value = phone;
    document.getElementById("editRole").value = role;

    document.getElementById("editModal").style.display = "flex";
}

function closeModal() {
    document.getElementById("editModal").style.display = "none";
}

function saveUser() {
    const formData = new FormData();
    formData.append("id", currentId);
    formData.append("name", document.getElementById("editName").value);
    formData.append("email", document.getElementById("editEmail").value);
    formData.append("phone", document.getElementById("editPhone").value);
    formData.append("role", document.getElementById("editRole").value);

    fetch("update_user.php", {
        method: "POST",
        body: formData
    })
    .then(() => {
        closeModal();
        loadUsers();
    })
}
