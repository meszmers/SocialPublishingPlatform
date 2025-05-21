import axios from "axios";

export async function getCategories() {
  return await axios.get(`http://localhost/api/categories`, {
    headers: {
      "Authorization": `Bearer ${localStorage.token}`,
      "Accept": "application/json",
      "Content-Type": "application/json",
    }
  })
}
