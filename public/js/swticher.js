if(document.querySelector('#editor'))
    var editor = ace.edit("editor");
let switches = document.getElementsByClassName('switch');
let style = localStorage.getItem('style');
let switcher = document.querySelector('.switcher')

if (style == null || style === 'default') {
    setTheme('default');
    switcher.classList.add('opacity-50')
} else {
    setTheme(style);
    switcher.classList.add('opacity-25')
}

// for (let i of switches) {
//     i.addEventListener('click', function () {
//         let theme = this.dataset.theme;
//         setTheme(theme);
//     });
// }

switcher.onclick = function (){
    if(localStorage.getItem('style') !== 'default'){
        setTheme('default')
        switcher.classList.remove('opacity-25')
        switcher.classList.add('opacity-50')
    }
    else {
        setTheme('dark')
        switcher.classList.remove('opacity-50')
        switcher.classList.add('opacity-25')
    }

}


function setTheme(theme) {
    if (theme == 'default') {
        document.getElementById('switcher-id').href = '/css/themes/default.css';
        if(typeof editor !=='undefined') editor.setTheme("ace/theme/crimson_editor");
    } else if (theme == 'wireframe') {
        document.getElementById('switcher-id').href = '/css/themes/wireframe.css';
        if(typeof editor !=='undefined') editor.setTheme("ace/theme/crimson_editor");
    } else if (theme == 'dark') {
        document.getElementById('switcher-id').href = '/css/themes/dark.css';
        if(typeof editor !=='undefined') editor.setTheme("ace/theme/tomorrow_night");
    }
    localStorage.setItem('style', theme);
}
