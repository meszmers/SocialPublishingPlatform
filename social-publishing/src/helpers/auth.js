export function storeUserData(userId, userName, userEmail) {

  localStorage.userId = userId;
  localStorage.userName = userName;
  localStorage.userEmail = userEmail;
}

export function clearUserData() {
  localStorage.removeItem('userId')
  localStorage.removeItem('userName')
  localStorage.removeItem('userEmail')
}
