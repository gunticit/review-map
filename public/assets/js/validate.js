function checkFileExtension(file, type='image'){
    if(type == 'image'){
        const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            return false;
        }
        return true;
    }else if(type == 'file'){
        const allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
        const fileExtension = file.name.split('.').pop().toLowerCase();
        if (!allowedExtensions.includes(fileExtension)) {
            return false;
        }
        return true;
    }
}

function checkFileSize(file){
    const fileSize = file.size / 1024 / 1024;
    if(fileSize > 2){
        return false;
    }
    return true;
}