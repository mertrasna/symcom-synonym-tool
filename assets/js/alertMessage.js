function errorMessagePopUp(message) {
    swal({
      type: 'error',
      title: 'Hoppla...',
      text: message+ ' !'
    });
}