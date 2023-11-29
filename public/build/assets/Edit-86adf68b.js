import{a as m,r as x,b as n,o,c as l,d as e,e as s,J as d,v as u,m as c,i as f}from"./app-c9829853.js";import{l as p}from"./loader-50bc1437.js";const k={class:"w-full box-border p-5"},y={class:"w-full relative overflow-x-auto shadow-md sm:rounded-lg"},h=e("div",{class:"box-border px-6 py-6 border-b bg-white flex justify-between items-center"},[e("h2",{class:"text-lg font-bold"},"Edit Materi")],-1),_={class:"w-full p-6 box-border"},v={class:"w-full flex items-center flex-col lg:flex-row lg:space-x-3"},w={class:"mb-6 w-1/3"},j=e("label",{for:"kelas",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Kelas",-1),M=e("option",null,"United States",-1),C=e("option",null,"Canada",-1),V=e("option",null,"France",-1),G=e("option",null,"Germany",-1),U=[M,C,V,G],A={class:"mb-6 w-1/3"},B=e("label",{for:"mapel",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Mata Pelajaran",-1),P=e("option",null,"United States",-1),S=e("option",null,"Canada",-1),D=e("option",null,"France",-1),F=e("option",null,"Germany",-1),L=[P,S,D,F],N={class:"mb-6 w-1/3"},E=e("label",{for:"guru",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Guru Pengampu",-1),I=e("option",null,"United States",-1),J=e("option",null,"Canada",-1),X=e("option",null,"France",-1),R=e("option",null,"Germany",-1),T=[I,J,X,R],z={class:"mb-6 w-full"},K=e("label",{for:"judul",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Judul / Nama Materi",-1),O={class:"mb-6 w-full"},$=e("label",{for:"deskripsi",class:"block mb-2 text-sm font-medium text-gray-900 dark:text-white"},"Deskripsi Materi",-1),q=f('<div class="w-full flex items-center flex-col lg:flex-row lg:space-x-3"><div class="mb-6 w-1/3"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Image</label><div class="flex items-center justify-center w-full"><label for="media-image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"><div class="flex flex-col items-center justify-center pt-5 pb-6"><svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path></svg><p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p><p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p></div><input id="media-image" type="file" class="hidden"></label></div></div><div class="mb-6 w-1/3"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media File</label><div class="flex items-center justify-center w-full"><label for="media-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"><div class="flex flex-col items-center justify-center pt-5 pb-6"><svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path></svg><p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p><p class="text-xs text-gray-500 dark:text-gray-400">PDF or DOC (MAX. 2mb)</p></div><input id="media-file" type="file" class="hidden"></label></div></div><div class="mb-6 w-1/3"><label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Media Video</label><div class="flex items-center justify-center w-full"><label for="media-video" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"><div class="flex flex-col items-center justify-center pt-5 pb-6"><svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"></path></svg><p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span></p><p class="text-xs text-gray-500 dark:text-gray-400">MP4 or AVI (MAX. 10mb)</p></div><input id="media-video" type="file" class="hidden"></label></div></div></div>',1),H={class:"border-t px-6 py-4 box-order"},Q={key:0,class:"flex items-center justify-end"},W={class:"flex items-center"},Y=["src"],Z=e("div",{class:"text-gray-600 italic"},"Menyimpan Data",-1),ee={key:1,class:"flex justify-end"},oe={__name:"Edit",setup(re){const i=m(),g=x(!1),t=n({id:null,id_kelas:"",id_rombel:"",id_guru:"",judul:"",slug:"",deskripsi:"",media_image:"",media_file:"",media_video:""});n({id_kelas:null,id_rombel:null,id_guru:null,judul:null,slug:null,deskripsi:null,media_image:null,media_file:null,media_video:null});const b=()=>{console.log("simpan"),i.push({name:"showMateri",params:{id:1}})};return(te,r)=>(o(),l("div",k,[e("div",y,[h,e("div",_,[e("div",v,[e("div",w,[j,s(e("select",{id:"kelas","onUpdate:modelValue":r[0]||(r[0]=a=>t.id_kelas=a),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"},U,512),[[d,t.id_kelas]])]),e("div",A,[B,s(e("select",{id:"mapel","onUpdate:modelValue":r[1]||(r[1]=a=>t.id_mapel=a),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"},L,512),[[d,t.id_mapel]])]),e("div",N,[E,s(e("select",{id:"guru","onUpdate:modelValue":r[2]||(r[2]=a=>t.id_guru=a),class:"bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"},T,512),[[d,t.id_guru]])])]),e("div",z,[K,s(e("textarea",{id:"judul","onUpdate:modelValue":r[3]||(r[3]=a=>t.judul=a),rows:"2",class:"block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"Theorema Phytagoras ..."},null,512),[[u,t.judul]])]),e("div",O,[$,s(e("textarea",{id:"deskripsi","onUpdate:modelValue":r[4]||(r[4]=a=>t.deskripsi=a),rows:"5",class:"block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500",placeholder:"sebuah Rumus untuk menghitung sisi terpanjang segitiga ......"},null,512),[[u,t.deskripsi]])]),q]),e("div",H,[g.value?(o(),l("div",Q,[e("div",W,[e("img",{src:c(p),alt:"",class:"w-8"},null,8,Y),Z])])):(o(),l("div",ee,[e("button",{onClick:r[5]||(r[5]=a=>c(i).push({name:"showMateri",params:{id:1}})),type:"button",class:"mr-5 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"}," Batal "),e("button",{onClick:b,type:"button",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"}," Simpan ")]))])])]))}};export{oe as default};
