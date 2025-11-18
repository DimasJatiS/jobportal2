// ---- JS Konfirmasi Delete + Animasi ----

document.addEventListener("DOMContentLoaded", () => {
    const modalOverlay = document.createElement('div');
    modalOverlay.classList.add('modal-overlay');
    modalOverlay.innerHTML = `
        <div class="modal-box">
            <h5>Yakin ingin menghapus data ini?</h5>
            <div class="modal-buttons">
                <button class="btn btn-danger btn-sm confirm-yes">Ya, hapus</button>
                <button class="btn btn-secondary btn-sm confirm-no">Batal</button>
            </div>
        </div>
    `;
    document.body.appendChild(modalOverlay);

    let currentForm = null;

    document.querySelectorAll('form[data-delete]').forEach(form => {
        form.addEventListener('submit', e => {
            e.preventDefault();
            currentForm = form;
            modalOverlay.style.display = 'flex';
        });
    });

    modalOverlay.querySelector('.confirm-yes').addEventListener('click', () => {
        if (currentForm) currentForm.submit();
        modalOverlay.style.display = 'none';
    });

    modalOverlay.querySelector('.confirm-no').addEventListener('click', () => {
        modalOverlay.style.display = 'none';
        currentForm = null;
    });
});
