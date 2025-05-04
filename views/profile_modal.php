<!-- views/profile_modal.php -->
<div class="modal fade" id="profileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Profil Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <?php
                $user_id = $_SESSION['user']['id'];
                $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $user = $stmt->get_result()->fetch_assoc();
                ?>
                
                <form id="profileForm" action="../pages/update_profile.php" method="POST" enctype="multipart/form-data">
                    <div class="text-center mb-4">
                        <img src="<?= $user['profile_picture'] ? '../'.$user['profile_picture'] : 'https://via.placeholder.com/150' ?>" 
                             class="rounded-circle mb-2 profile-picture"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <div class="mt-2">
                            <input type="file" name="profile_picture" class="form-control d-none" id="profilePictureInput">
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="document.getElementById('profilePictureInput').click()" disabled>
                                <i class="bi bi-camera"></i> Ganti Foto
                            </button>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="full_name" class="form-control" 
                                       value="<?= $user['full_name'] ?>" disabled>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" 
                                       value="<?= $user['username'] ?>" disabled>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= $user['email'] ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">No. HP</label>
                                <input type="tel" name="phone_number" class="form-control" 
                                       value="<?= $user['phone_number'] ?>" disabled>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select class="form-select" name="gender" disabled>
                                    <option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>Perempuan</option>
                                    <option value="other" <?= $user['gender'] == 'other' ? 'selected' : '' ?>>Lainnya</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="address" class="form-control" 
                                          rows="3" disabled><?= $user['address'] ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i> Tutup
                        </button>
                        
                        <div class="btn-group">
                            <button type="button" class="btn btn-outline-primary" id="editButton">
                                <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <button type="submit" class="btn btn-primary d-none" id="saveButton">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                            <button type="button" class="btn btn-secondary d-none" id="cancelButton">
                                <i class="bi bi-arrow-counterclockwise"></i> Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editButton').addEventListener('click', function() {
    const inputs = document.querySelectorAll('#profileForm input, #profileForm select, #profileForm textarea');
    inputs.forEach(input => {
        input.disabled = false;
        if(input.type === 'file') {
            input.parentElement.querySelector('button').disabled = false;
        }
    });
    
    document.getElementById('profilePictureInput').classList.remove('d-none');
    document.querySelector('.profile-picture').parentElement.querySelector('button').classList.remove('d-none');
    
    this.classList.add('d-none');
    document.getElementById('saveButton').classList.remove('d-none');
    document.getElementById('cancelButton').classList.remove('d-none');
});

document.getElementById('cancelButton').addEventListener('click', function() {
    location.reload(); // Reset form ke keadaan semula
});
</script>