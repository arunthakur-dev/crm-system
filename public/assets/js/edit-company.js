// JavaScript for Modal
 
document.querySelector('.company-header').addEventListener('click', function () {
    document.getElementById('editCompanyModal').style.display = 'flex';
});

document.querySelectorAll('.close-modal').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editCompanyModal').style.display = 'none';
    });
});
 

// JavaScript for Edit Company Modal  
const fieldModal = document.getElementById('editCompanyModal');
const form = fieldModal.querySelector('form');
const fieldMap = {
    name: 'company_name',
    industry: 'industry',
    employees: 'employees'
};

document.querySelectorAll('.editable-field').forEach(field => {
    field.addEventListener('click', () => {
        const key = field.dataset.field;
        const value = field.dataset.value;

        // Clear all inputs
        form.reset();

        // Set the modal field value
        if (key === 'industry') {
            form.querySelector('select[name="industry"]').value = value;
        } else {
            form.querySelector(`#${fieldMap[key]}`).value = value;
        }

        // Optional: Scroll to that field in the modal
        orm.querySelector(`#${fieldMap[key]}`).scrollIntoView({ behavior: 'smooth' });

        // Show modal
        fieldModal.style.display = 'flex';
    });
});
 
 
// JavaScript for About Field Modal

const aboutFieldModal = document.getElementById('editAboutFieldModal');
const aboutFieldForm = document.getElementById('aboutFieldForm');

document.querySelectorAll('.editable-field').forEach(field => {
    field.querySelector('.inline-edit-btn').addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent event bubbling
        const fieldKey = field.dataset.field;
        const fieldValue = field.dataset.value || '';
        const labelText = field.querySelector('label').innerText;

        document.getElementById('field_name').value = fieldKey;
        document.getElementById('field_value').value = fieldValue;
        document.getElementById('field_label').innerText = labelText;

        aboutFieldModal.style.display = 'flex';
    });
});

document.querySelectorAll('.close-about-modal').forEach(btn => {
    btn.addEventListener('click', () => {
       aboutFieldModal.style.display = 'none';
    });
});
 

// JavaScript for Delete Company Modal
const deleteModal = document.getElementById('deleteConfirmModal');
const triggerDelete = document.getElementById('triggerDeleteModal');
const cancelDelete = document.getElementById('cancelDeleteBtn');
const confirmDelete = document.getElementById('confirmDeleteBtn');
const deleteForm = document.getElementById('deleteCompanyForm');

triggerDelete.addEventListener('click', () => {
    deleteModal.style.display = 'flex';
});

cancelDelete.addEventListener('click', () => {
    deleteModal.style.display = 'none';
});

confirmDelete.addEventListener('click', () => {
    deleteForm.submit();
});

// Optional: Close modal if clicked outside content
window.addEventListener('click', function (e) {
    if (e.target === deleteModal) {
        deleteModal.style.display = 'none';
    }
});