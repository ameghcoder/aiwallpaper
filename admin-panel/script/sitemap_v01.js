$(document).ready(()=>{
    const _remove_an_element_after_time = (_class_of_ele, _time_in_milisecond) => {
        return setTimeout(() => {
            document.querySelector(_class_of_ele).remove();
        }, _time_in_milisecond);
    }
    let _num_of_msg_box = 0;
    let _time_of_msg_box = 5000;
    const showResponse = (msg, flag) => {
        let _msg_html = "";
        if(flag == "w" || flag == "wrong" || flag == "e" || flag == "error"){
            _msg_html =     `<div class="message-printer mp-box-${_num_of_msg_box}" style="background-color: red;">
                                <div class="mp-inside">
                                    <strong>Error : </strong>
                                    <p>${msg}</p>
                                </div>
                                <div onclick="document.querySelector('.mp-box-${_num_of_msg_box}').remove();" class="msg-close-btn">❌</div>
                            </div>`;
        } else if(flag == "s" || flag == "success"){
            _msg_html =     `<div class="message-printer mp-box-${_num_of_msg_box}" style="background-color: green;">
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
    function update(_which, _flag){
        console.log(_which);
        console.log(_flag);
        return new Promise((resolve, reject)=>{
            $.ajax({
                type:"GET",
                url:`../red_zone/update_content?which=${_which}&flag=${_flag}`,
                success: function(response){
                    resolve(response);
                },
                error: function(error){
                    reject("An Error Occurred : Call to Developer\nSend this code to Developer : " + error);
                }
            })
        })
    }
    $('.update-cnbt-number').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('hmcatenum', '')
        .then((val)=>{
            $(e.target).removeClass('loading-gif');
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            $(e.target).removeClass('loading-gif');
            showResponse("Error : " + err, "e");
        })
    })
    $('.update-recent-section-code-a-isi').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('recentisi', 'a')
        .then((val)=>{
            $(e.target).removeClass('loading-gif');
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            $(e.target).removeClass('loading-gif');
            showResponse("Error : " + err, "e");
        })
    })
    $('.update-recent-section-code-d-isi').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('recentisi', 'c')
        .then((val)=>{
            $(e.target).removeClass('loading-gif');
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            $(e.target).removeClass('loading-gif');
            showResponse("Error : " + err, "e");
        })
    })
    $('.update-recent-section-code-d').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('recent', 'c')
        .then((val)=>{
            $(e.target).removeClass('loading-gif');
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            $(e.target).removeClass('loading-gif');
            showResponse("Error : " + err, "e");
        })
    })
    $('.update-recent-section-code-a').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('recent', 'a')
        .then((val)=>{
            $(e.target).removeClass('loading-gif');
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            $(e.target).removeClass('loading-gif');
            showResponse("Error : " + err, "e");
        })
    })
    
    $('.update-sitemap-code').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
        update('sitemap')
        .then((val)=>{
            let json_string = JSON.parse(val);
            if(json_string['flag'] == "s"){
                $(e.target).removeClass('loading-gif');
                showResponse(json_string['msg'], "s");
            } else{
                showResponse(json_string['msg'], json_string['flag']);
            }
        })
        .catch((err)=>{
            showResponse("Error : " + err, "e");
        })
    })
    $('.submit-url-on-google').on('click', (e)=>{
        $(e.target).addClass('loading-gif');
        let url = "https://www.wallpaper-access.com/sitemap.xml";
        fetch(`https://www.google.com/ping?sitemap=${url}`)
        .then(y=>{
            console.log(y);
        })
        .catch(err=>{
            console.log(err);
        })
    })
    $('.submit-url-on-google-img').on('click', (e)=>{
        $(e.target).addClass('loading-gif');
        let url = "https://www.wallpaper-access.com/imgSitemap.xml";
        fetch(`https://www.google.com/ping?sitemap=${url}`)
        .then(y=>{
            console.log(y);
        })
        .catch(err=>{
            console.log(err);
        })
    })
    $('.submit-url-on-bing').on('click', (e)=>{
        console.log("working");
        $(e.target).addClass('loading-gif');
    })
})