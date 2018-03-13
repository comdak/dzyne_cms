function confirmDelete(delUrl) {
  if (confirm("Are you sure you want to delete this item?")) {
   document.location = delUrl;
  }
}
