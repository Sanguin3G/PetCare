<section class="pc-security-card">
    <span class="pc-section-kicker">Tài khoản PetCare</span><h1>Đổi mật khẩu</h1>
    <p>Bảo vệ tài khoản bằng mật khẩu riêng, ít nhất 8 ký tự.</p>
    <form id="formChange">
        <div class="mb-3"><label for="currentPassword" class="form-label">Mật khẩu hiện tại</label><input type="password" id="currentPassword" name="old_password" autocomplete="current-password" class="form-control" required></div>
        <div class="mb-3"><label for="yourPassword" class="form-label">Mật khẩu mới</label><input type="password" id="yourPassword" name="new_password" autocomplete="new-password" class="form-control" minlength="8" required></div>
        <div class="mb-3"><label for="yourConfirmPassword" class="form-label">Xác nhận mật khẩu mới</label><input type="password" id="yourConfirmPassword" autocomplete="new-password" class="form-control" minlength="8" required></div>
        <p id="password-feedback" role="status" aria-live="polite"></p><button class="btn pc-primary-cta" type="submit">Lưu mật khẩu</button>
    </form>
</section>
