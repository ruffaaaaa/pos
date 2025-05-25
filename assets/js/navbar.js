$(document).ready(function () {
    $('#sortTable').DataTable();
});



function toggleDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('hidden');
}

// Optional: Close dropdown when clicking outside
document.addEventListener('click', function (e) {
    const profile = document.querySelector('.topbar-right');
    const dropdown = document.getElementById('profileDropdown');
    if (!profile.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});


function openModal() {
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}





