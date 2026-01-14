function loadUsers() {
    fetch("get_user.php")
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector("#users-table tbody");
            tbody.innerHTML = "";

            data.forEach(user => {
                tbody.innerHTML += `
                    <tr>
                        <td>${user.id}</td>
                        <td>${user.emri}</td>
                        <td>${user.email}</td>
                        <td>${user.phone}</td>
                        <td>${user.role}</td>
                        <td>
                            <button class="action-btn edit-btn" onclick="openEdit(${user.id}, '${user.emri}', '${user.email}', '${user.phone}', '${user.role}')">Edit</button>
                            <button class="action-btn delete-btn" onclick="deleteUser(${user.id})">Delete</button>
                        </td>
                    </tr>
                `;
            });
        });
}

loadUsers();

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
