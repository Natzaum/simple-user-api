const API_URL = 'http://localhost:8000/users'

async function getUsers() {
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