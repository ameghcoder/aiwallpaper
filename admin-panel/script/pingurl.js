$(document).ready(()=>{
    $('body').on('click', '.ping-on-bing', (e)=>{
        let pageurl = e.target.getAttribute('data-url');
        fetch(`https://www.bing.com/indexnow?url=${pageurl}&key=6f1058c2d3b04179afbd6b2e21de43a7`)
        .then(x=>console.log(x))
        .catch(err=>console.log(err));
    })
})