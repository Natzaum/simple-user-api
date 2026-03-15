const API_URL = 'http://localhost:8000/users'

async function getAllUsers() {
    const response = await fetch(API_URL)
    const data = await (response.json())

    const list = document.getElementById('user-list')
    list.innerHTML = ""

    data.forEach(user => {
        const row = document.createElement('tr')
        const cell = document.createElement('td')
        cell.textContent = `${user.id} - ${user.name} - ${user.email} - ${user.username}`
        row.appendChild(cell)
        list.appendChild(row)
    })
}

getAllUsers()

async function createUser(event) {
    event.preventDefault()

    const name = document.getElementById('create-name').value
    const email = document.getElementById('create-email').value
    const username = document.getElementById('create-username').value
    const password = document.getElementById('create-password').value

    const response = await fetch(API_URL, {
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

    const result = await response.json()

    if (!response.ok) {
        alert(result.message ?? 'Failed to create user')
        return
    }

    document.getElementById('create-form').reset()
    await getAllUsers()
    alert('User created successfully')
}

document.getElementById('create-form').addEventListener('submit', createUser)

async function updateUser(event) {
    event.preventDefault()

    const id = document.getElementById('update-id').value
    if (!id) {
        alert('Please provide a valid user ID.')
        return
    }
    const name = document.getElementById('update-name').value
    const email = document.getElementById('update-email').value
    const username = document.getElementById('update-username').value
    const password = document.getElementById('update-password').value

    const response = await fetch(`${API_URL}/${id}`, {
        method: 'PUT',
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

    const result = await response.json()

    if (!response.ok) {
        alert(result.message ?? 'Failed to update user')
        return
    }

    document.getElementById('update-form').reset()
    await getAllUsers()
    alert('User updated successfully')
}

document.getElementById('update-form').addEventListener('submit', updateUser)

async function deleteUser(event) {
    event.preventDefault()

    const id = document.getElementById('delete-id').value
    if (!id) {
        alert('Please provide a valid user ID.')
        return
    }

    const response = await fetch(`${API_URL}/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    })

    const result = await response.json()

    if (!response.ok) {
        alert(result.message ?? 'Failed to delete user')
        return
    }

    document.getElementById('delete-form').reset()
    await getAllUsers()
    alert('User deleted successfully')
}

document.getElementById('delete-form').addEventListener('submit', deleteUser)
