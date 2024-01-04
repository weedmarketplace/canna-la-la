<div class="modal fade theme-modal" id="ageVerificationModal" tabindex="-1"aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Age Verification Required</h5>
                </div>
        
                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-xxl-12">
                            <div class="form-floating theme-form-floating">
                                <p class="coming-text">To access this site, you must confirm that you are 21 years of age or older. This is to comply with regulations and ensure responsible use of our content. Please verify your age to continue.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" onclick="confirmAge()" class="btn theme-bg-color btn-md fw-bold text-light">Yes, I am 21 or older</button>
                </div>
        </div>
    </div>
</div>
<script>
    window.onload = function() {
        if (!localStorage.getItem('ageVerified')) {
            $('#ageVerificationModal').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#ageVerificationModal').modal('show');
            document.getElementById('ageVerificationModal').style.display = 'block';
        }
    };
    function confirmAge() {
        localStorage.setItem('ageVerified', 'true');
        $('#ageVerificationModal').modal('hide');
    }
</script>