const API_URL = 'http://localhost:8000/users'

async function getAllUsers() {
    const response = await fetch(API_URL)
    const data = await (response.json())

    const list = document.getElementById('userList')
    list.innerHTML = ""

    data.forEach(user => {
        const li = document.createElement('li')
        li.textContent = `${user.id} - ${user.name} - ${user.email} - ${user.username}`
        list.appendChild(li)
    })
}

getAllUsers()

async function createUser() {
    const name = document.getElementById('name').value
    const email = document.getElementById('email').value
    const username = document.getElementById('username').value

    await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name,
            email,
            username
        })
    })

    alert('User created successfully')
}

document.getElementById('createForm').addEventListener('submit', createUser)

async function updateUser() {
    const id = document.getElementById('updateId').value
    const name = document.getElementById('updateName').value
    const email = document.getElementById('updateEmail').value
    const username = document.getElementById('updateUsername').value

    await fetch(API_URL, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id,
            name,
            email,
            username
        })
    })

    alert('User updated successfully')
}

document.getElementById('updateForm').addEventListener('submit', updateUser)

async function deleteUser() {
    const id = document.getElementById('deleteId').value

    await fetch(API_URL, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id
        })
    })

    alert('User deleted successfully')
}

document.getElementById('deleteForm').addEventListener('submit', deleteUser)