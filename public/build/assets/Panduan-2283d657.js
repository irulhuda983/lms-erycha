import{o as a,c as l,d as o,m as r,w as c,J as i}from"./app-7f2918f6.js";const u="/build/assets/cover-panduan-c23b479a.png",b={class:"w-full box-border p-5 mt-14"},m={class:"w-full relative overflow-x-auto sm:rounded-lg"},p={class:"w-full lg:w-1/4 bg-white box-border overflow-hidden rounded-lg"},w={class:"w-full box-border"},_=["src"],f={class:"w-full box-border p-4"},h=o("p",{class:"font-semibold text-xs lg:text-sm mb-5"},"Buku Panduan Penggunaan Aplikasi (Manual Book) DMC LMS App.",-1),g={__name:"Panduan",setup(v){const d=s=>{i.get(s,{responseType:"blob"}).then(t=>{const n=window.URL.createObjectURL(t.data),e=document.createElement("a");e.href=n,e.download="manual-book.pdf",document.body.appendChild(e),e.click(),document.body.removeChild(e),window.URL.revokeObjectURL(n)}).catch(console.error)};return(s,t)=>(a(),l("div",b,[o("div",m,[o("div",p,[o("div",w,[o("img",{src:r(u),alt:""},null,8,_)]),o("div",f,[h,o("button",{onClick:t[0]||(t[0]=c(n=>d("/manual-book.pdf"),["prevent"])),class:"w-full bg-[#059BDD] text-white box-border p-2 rounded font-semibold"},"Download")])])])]))}};export{g as default};
