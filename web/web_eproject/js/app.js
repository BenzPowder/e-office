function swalLoading () {
  swal({
    text: 'Loading...',
    buttons: false,
    icon:epro_path+'/web_eproject/images/loading.gif',
    closeOnClickOutside: false,
    // closeOnEsc: false,
  })
}
function swalNotFound () {
  swal({
    text: 'ไม่พบข้อมูล!',
    icon:'warning',
  })
}