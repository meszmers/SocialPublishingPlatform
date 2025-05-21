import axios from "axios";

export async function authenticate(email, password) {
  return await axios.post('http://localhost/api/auth/login', {
    'email': email,
    'password': password,
  }, {
    headers: {
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  });
}

export async function logoutFromCurrentSession() {
  return await axios.post('http://localhost/api/auth/logout', {}, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}

export async function checkCurrentSession() {
  return await axios.post('http://localhost/api/auth/check', {}, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}
