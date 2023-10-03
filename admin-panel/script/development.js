$(document).ready(() => {
    const _remove_an_element_after_time = (_class_of_ele, _time_in_milisecond) => {
        return setTimeout(() => {
            document.querySelector(_class_of_ele).remove();
        }, _time_in_milisecond);
    }
    let _num_of_msg_box = 0;
    let _time_of_msg_box = 5000;
    const showResponse = (msg, flag) => {
        let _msg_html = "";
        if (flag == "w" || flag == "wrong" || flag == "e" || flag == "error") {
            _msg_html = `<div class="message-printer mp-box-${_num_of_msg_box}" style="background-color: red;">
                                <div class="mp-inside">
                                    <strong>Error : </strong>
                                    <p>${msg}</p>
                                </div>
                                <div onclick="document.querySelector('.mp-box-${_num_of_msg_box}').remove();" class="msg-close-btn">❌</div>
                            </div>`;
        } else if (flag == "s" || flag == "success") {
            _msg_html = `<div class="message-printer mp-box-${_num_of_msg_box}" style="background-color: green;">
                                <div class="mp-inside">
                                    <strong>Success : </strong>
                                    <p>${msg}</p>
                                </div>
                                <div onclick="document.querySelector('.mp-box-${_num_of_msg_box}').remove();" class="msg-close-btn">❌</div>
                            </div>`;
        }
        let messagePrinterBox = document.querySelector('.message-printer-box');
        messagePrinterBox.insertAdjacentHTML('beforeend', _msg_html);
        _remove_an_element_after_time(`.mp-box-${_num_of_msg_box}`, _time_of_msg_box);
        _num_of_msg_box++;
        _time_of_msg_box += 1000;
    }
    // make a function for show the all wallpapers data on load
    const getData = async (id, num) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: `../red_zone/data_send?id=${id}&number=${num}`,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    console.error("An Error Occurred : Call to Developer\nSend this code to Developer : " + e);
                    reject("An Error Occurred : Call to Developer\nSend this code to Developer : " + e);
                }
            })
        })
    }
    const checkURL = () => {
        let url = window.location.href;
        url = url.split('/');
        for (let i = 0; i < url.length; i++) {
            if (url[i] == "dashboard") {
                if (url[i + 1] == "edit") {
                    return true;
                }
            }
        }
        return false;
    }
    const getId = () => {
        if (document.querySelector('.table-data-row')) {
            let tempData = document.querySelectorAll('.table-data-row');
            return tempData[tempData.length - 1].getAttribute('data-serial-number');
        } else {
            return 1;
        }
    }
    // set data in edit section in table form
    async function setData(_num) {
        if (checkURL()) {
            let id = getId();
            let data = await getData(id, _num);
            let AppendData = document.querySelector('.tbody');
            AppendData.innerHTML += data;
        }
    }
    setData(25);

    let lmfead = document.querySelector('.lmfead') ? document.querySelector('.lmfead') : 0;
    if (lmfead) {
        document.querySelector('.lmfead').addEventListener('click', () => {
            setData(100);
        })
    }

    // Set Image File for Preview
    const ImgData = (e) => {
        let img = new FileReader();
        img.readAsDataURL(e);
        img.onload = (e) => {
            // Set image in preview img tag
            let i = new Image();
            i.src = e.target.result;
            i.onload = () => {
                let oriWid = i.width;
                let oriHei = i.height;
                if (oriWid > oriHei) {
                    showResponse("This image is not for Android, Please upload only Android Image", "w");
                } else if (oriWid == oriHei) {
                    showResponse("This is a square image, Please crop it in 9:16 ratio and then upload", "w");
                } else {
                    $('.preview').attr('src', e.target.result);
                }
            }
        }
        img.onerror = () => {
            console.error("This image is not valid. Try again or Try another");
        }
    }

    // on wallpaper upload using input tag
    let wData = undefined;
    $('#wallpaper').change(function () {
        wData = this.files[0];
        ImgData(this.files[0]);
    })
    // Set Image File for Preview

    // Click on Upload Button
    const upload_data = async (data) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `../red_zone/data_upload`,
                type: "POST",
                data: data,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    reject(e);
                },
                cache: false,
                contentType: false,
                processData: false
            })
        })
    }
    let wallUploadBtn = document.querySelector('.uploadBtn') ? document.querySelector('.uploadBtn') : 0;
    if (wallUploadBtn) {
        wallUploadBtn.addEventListener('click', () => {
            let inputName = selectCategory = tags = description = username = undefined;
            inputName = $('#wallpaper-name').val();
            tags = $('#tags').val();
            description = $('#description').val();

            if (wData !== undefined || tags !== undefined || inputName !== undefined || description !== undefined) {
                let form = new FormData();
                form.append("wallpaperData", wData);
                form.append("wallpaperName", inputName);
                form.append("wallpaperTags", tags);
                form.append("wallpaperDescription", description);
                form.append("username", username);
                upload_data(form).then((val) => {
                    let json_string = JSON.parse(val);
                    if (json_string['flag'] == "s") {
                        json_string = json_string['msg'].split(',');
                        for (let i = 0; i < json_string.length; i++) {
                            showResponse(json_string[i], "s");
                        }
                    } else {
                        showResponse(json_string['msg'], json_string['flag']);
                    }
                }).catch((err) => {
                    showResponse(err, "e");
                })
            } else {
                console.log("Please upload Image");
            }
        })
    }
    // get the data of wallpaper id for editing

    // on write keywords or description
    let _on_change_keywords_check_condition = document.getElementById('tags') ? document.getElementById('tags') : 0;
    if (_on_change_keywords_check_condition) {
        _on_change_keywords_check_condition.addEventListener('change', (e) => {
            $('._keyword_length').html(e.target.value.length);
            if (e.target.value.length > 250) {
                $('.uploadBtn').attr('disabled', true);
                $('.uploadBtn').html('Too many keywords');
                $('.uploadBtn').css({ 'opacity': '0.5', 'background-color': 'red' });
            } else if (e.target.value.length < 150) {
                $('.uploadBtn').attr('disabled', true);
                $('.uploadBtn').html('Too Low keywords');
                $('.uploadBtn').css({ 'opacity': '0.5', 'background-color': 'red' });
            } else {
                $('.uploadBtn').html('Upload');
                $('.uploadBtn').attr('disabled', false);
                $('.uploadBtn').css({ 'opacity': '1', 'background-color': 'var(--fore-clr)' });

            }
        })
        document.getElementById('description').addEventListener('keypress', (e) => {
            $('._description_length').html(e.target.value.length);
            if (e.target.value.length > 250) {
                $('.uploadBtn').html('Too long description');
                $('.uploadBtn').attr('disabled', true);
                $('.uploadBtn').css({ 'opacity': '0.5', 'background-color': 'red' });
            } else if (e.target.value.length < 80) {
                $('.uploadBtn').html('Too short description');
                $('.uploadBtn').attr('disabled', true);
                $('.uploadBtn').css({ 'opacity': '0.5', 'background-color': 'red' });
            } else {
                $('.uploadBtn').html('Upload');
                $('.uploadBtn').attr('disabled', false);
                $('.uploadBtn').css({ 'opacity': '1', 'background-color': 'var(--fore-clr)' });
            }
        })
    }

    let _on_change_keywords_check_condition_for_edit = document.getElementById('update-tags') ? document.getElementById('update-tags') : 0;
    if (_on_change_keywords_check_condition_for_edit) {
        _on_change_keywords_check_condition_for_edit.addEventListener('change', (e) => {
            $('._keyword_length').html(e.target.value.length);
            if (e.target.value.length > 250 && e.target.value.length < 150) {
                if (e.target.value.length > 250) {
                    $('.edit-this-wallpaper-info').attr('disabled', true);
                    $('.edit-this-wallpaper-info').html('Too many keywords');
                    $('.edit-this-wallpaper-info').css({ 'opacity': '0.5', 'background-color': 'red' });
                } else if (e.target.value.length < 150) {
                    $('.edit-this-wallpaper-info').attr('disabled', true);
                    $('.edit-this-wallpaper-info').html('Too Low keywords');
                    $('.edit-this-wallpaper-info').css({ 'opacity': '0.5', 'background-color': 'red' });
                }
            } else {
                $('.edit-this-wallpaper-info').html('Upload');
                $('.edit-this-wallpaper-info').attr('disabled', false);
                $('.edit-this-wallpaper-info').css({ 'opacity': '1', 'background-color': 'var(--fore-clr)' });
            }
        })
        document.getElementById('update-description').addEventListener('change', (e) => {
            $('._description_length').html(e.target.value.length);
            if (e.target.value.length > 200 && e.target.value.length < 80) {
                if (e.target.value.length > 200) {
                    $('.edit-this-wallpaper-info').html('Too long description');
                    $('.edit-this-wallpaper-info').attr('disabled', true);
                    $('.edit-this-wallpaper-info').css({ 'opacity': '0.5', 'background-color': 'red' });
                } else if (e.target.value.length < 80) {
                    $('.edit-this-wallpaper-info').html('Too short description');
                    $('.edit-this-wallpaper-info').attr('disabled', true);
                    $('.edit-this-wallpaper-info').css({ 'opacity': '0.5', 'background-color': 'red' });
                }
            } else {
                $('.edit-this-wallpaper-info').html('Upload');
                $('.edit-this-wallpaper-info').attr('disabled', false);
                $('.edit-this-wallpaper-info').css({ 'opacity': '1', 'background-color': 'var(--fore-clr)' });
            }
        })
    }

    const return_complete_data_for_specific_id = (id) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: `../red_zone/data_send?specific_id=${id}`,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    reject("An Error Occurred : Call to Developer\nSend this code to Developer : " + e);
                }
            })
        })
    }
    const return_complete_data_for_specific_id_desc = (id) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: `../red_zone/data_send?specific_id_desc=${id}`,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    reject("An Error Occurred : Call to Developer\nSend this code to Developer : " + e);
                }
            })
        })
    }
    $('body').on('click', '.edit-wall-btn', (e) => {
        return_complete_data_for_specific_id(e.target.getAttribute("data-id"))
            .then((val) => {
                let data_in_json = JSON.parse(val);
                let title_from_json = data_in_json[2].split('.')[0];
                let img_from_json = '/jpeg/' + data_in_json[2];
                $('.edsbib-img').attr('src', img_from_json)
                $('#update-title').val(title_from_json);
                $('.edsbib-id').html(data_in_json[0]);
                $('#update-tags').val(data_in_json[1]);
                $('#update-category').val(data_in_json[6])
                $('.ed-show-box').css('transform', 'scale(1)');

                return_complete_data_for_specific_id_desc(e.target.getAttribute("data-id"))
                    .then((val) => {
                        if (val != "" || val != null || val != false) {
                            val = val.replaceAll('"', "");
                            $('#update-description').val(val);
                        } else {
                            $("#update-description").val("");
                        }
                    })
            })
            .catch((err) => {
                showResponse("Error : " + err, "e");
            })
    })
    $('body').on('click', '.delete-wall-btn', (e) => {
        $('.del-show-box').css('transform', 'scale(1)');
        $('.yes-delete-this').attr('data-id', e.target.getAttribute('data-id'));
    })
    // Edit Button Function
    const edit_data = async (data) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `../red_zone/data_edit`,
                type: "POST",
                data: data,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    reject(e);
                },
                cache: false,
                contentType: false,
                processData: false
            })
        })
    }
    // edit this wallpaper info function
    let update_title, update_category, update_tags, update_description, wall_id;
    $('.edit-this-wallpaper-info').on('click', (e) => {
        // update info
        update_title = $('#update-title').val();
        update_tags = $('#update-tags').val();
        update_description = $('#update-description').val();
        update_category = $('#update-category').val();
        wall_id = $('.edsbib-id').html();
        let form = new FormData();
        form.append("update_title", update_title);
        form.append("update_tags", update_tags);
        form.append("update_description", update_description);
        form.append("update_category", update_category);
        form.append("wall_id", wall_id);
        edit_data(form).then((val) => {
            let json_string = JSON.parse(val);
            if (json_string['flag'] == "s") {
                showResponse(json_string['msg'], "s");
            } else {
                showResponse(json_string['msg'], json_string['flag']);
            }
        }).catch((err) => {
            showResponse(err, "e");
        })
    })
    const return_response_for_delete_wall = (id) => {
        return new Promise((resolve, reject) => {
            $.ajax({
                type: "GET",
                url: `../red_zone/data_delete?delete_id=${id}`,
                success: function (response) {
                    resolve(response);
                },
                error: function (e) {
                    reject("An Error Occurred : Call to Developer\nSend this code to Developer : " + e);
                }
            })
        })
    }
    $('.yes-delete-this').on('click', (e) => {
        return_response_for_delete_wall(e.target.getAttribute('data-id'))
            .then((val) => {
                showResponse(val, "s");
                location.reload();
            })
            .catch((err) => {
                showResponse(err, "w");
            })
    })
})