import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const form = document.getElementById('delete-form')
const faculty = document.getElementById('faculty')
const selectFaculty = document.getElementById('faculty-select')
const institute = document.getElementById('institute')
const title = document.getElementById('title')
const menu = document.getElementById('menu')
const wrap = document.getElementById('wrap')
const header = document.getElementById('header')
const titles = document.querySelectorAll('.title')
const side = document.querySelector('aside')
const deleteBtn = document.querySelectorAll('#delete')
const deleteInstitute = document.querySelectorAll('#delete-institute')
const deleteAdmin = document.querySelectorAll('#delete-btn')
const facultyForm=document.getElementById('faculty-form')
const facultyList=document.getElementById('faculty-list')

let open = JSON.parse(localStorage.getItem('open-form')) || false
let openTitle = JSON.parse(localStorage.getItem('menu')) || false
institute?.addEventListener('change',(e)=>{
    let faculties = JSON.parse(institute.dataset.faculties)?.filter(fac => fac.institute_id==e.target.value)
    let options = '<option value="">Select faculty</option>'
    faculties.forEach(op =>{
       options += `<option value="${op.id}">${op.faculty_name}</option>`
    })
    selectFaculty.innerHTML= options
})
facultyFun()
faculty?.addEventListener('click',()=>{
        open = !open
        localStorage.setItem('open-form',JSON.stringify(open))
        facultyFun()
    })

menu?.addEventListener('click',()=>{
    openTitle = !openTitle
    localStorage.setItem('menu',JSON.stringify(openTitle))
    showTitles()
})

showTitles()
deleteBtn.forEach(btn=>{
    btn.addEventListener('click',()=>{
        sendDelete(btn)
    })
})

deleteAdmin.forEach(btn=>{
    btn.addEventListener('click',()=>{
        sendDeleteAdmin(btn)
    })
})

deleteInstitute.forEach(btn=>{
    btn.addEventListener('click',()=>{
        sendDeleteInstitute(btn)
    })
})

function sendDelete(el){
    const id = el.dataset.facultyId
    form.action='http://higher_learnings.test/faculty/'+id
    form.submit()
}

function sendDeleteAdmin(el){
    const id = el.dataset.adminId
    form.action='http://higher_learnings.test/admin/'+id
    form.submit()
}
function sendDeleteInstitute(el){
    const id = el.dataset.id
    form.action='http://higher_learnings.test/ad/institute/'+id
    form.submit()
}
function facultyFun(){
    if (facultyForm) {
        if(open){
            show(facultyForm)
            hide(facultyList)
            title.innerHTML='New '+title.dataset.title
            faculty.innerHTML='Show '+title.dataset.list
        } else{
            hide(facultyForm)
            show(facultyList) 
            title.innerHTML= title.dataset.list
            faculty.innerHTML='Create '+title.dataset.title
        }
    }
}
function hide(el){
    el.style.display='none'
}

function show(el){
    el.style.display='block'
}
function showTitles() {
    titles.forEach(elTitle=>{
      if(openTitle){
            show(elTitle)
            side.classList.add('w-[200px]')
            side.style.width='200px'
            header.style.left='200px'
            wrap.style.marginLeft='200px'
        } else{
            side.classList.remove('w-[200px]')
            header.classList.remove('left-[200px]')
            header.style.left='60px'
            side.style.width='60px'
            wrap.classList.remove('ml-[200px]')
             wrap.style.marginLeft='60px'
            hide(elTitle)
        }  
    })
    
}

    