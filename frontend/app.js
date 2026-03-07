const API_URL = 'http://localhost:8000/users'

async function getAllUsers() {
    const response = await fetch(API_URL)
    const data = await (response.json())

    const list = document.getElementById('userList')
    list.innerHTML = ""

    data.forEach(user => {
        const li = document.createElement('li')
        li.textContent = `${user.name} - ${user.email} - ${user.username}`
        list.appendChild(li)
    })
}

async function createUser(e) {
    e.preventDefault()

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