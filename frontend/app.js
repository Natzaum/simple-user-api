const API_URL = 'http://localhost:8000/users'

async function getAllUsers() {
    const response = await fetch(API_URL)
    const data = await (response.json())

    const list = document.getElementById('user-list')
    list.innerHTML = ""

    data.forEach(user => {
        const li = document.createElement('li')
        li.textContent = `${user.id} - ${user.name} - ${user.email} - ${user.username}`
        list.appendChild(li)
    })
}

getAllUsers()

async function createUser() {
    const name = document.getElementById('create-name').value
    const email = document.getElementById('create-email').value
    const username = document.getElementById('create-username').value
    const password = document.getElementById('create-password').value

    await fetch(API_URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name,
            email,
            username,
            password,
        })
    })

    alert('User created successfully')
}

document.getElementById('create-form').addEventListener('submit', createUser)

async function updateUser() {
    const id = document.getElementById('update-id').value
    const name = document.getElementById('update-name').value
    const email = document.getElementById('update-email').value
    const username = document.getElementById('update-username').value
    const password = document.getElementById('update-password').value

    await fetch(API_URL, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id,
            name,
            email,
            username,
            password,
        })
    })

    alert('User updated successfully')
}

document.getElementById('update-form').addEventListener('submit', updateUser)

async function deleteUser() {
    const id = document.getElementById('delete-id').value

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

document.getElementById('delete-form').addEventListener('submit', deleteUser)