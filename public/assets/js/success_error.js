function success_error(type, msg) {
    Swal.fire({
        text: msg,
        icon: type,
        position: 'top-end',
        toast: true,
        timer: 5000,
        timerProgressBar: true,
        showConfirmButton: false
    });// Show success message
}