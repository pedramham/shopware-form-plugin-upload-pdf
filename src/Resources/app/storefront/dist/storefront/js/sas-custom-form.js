"use strict";(self.webpackChunk=self.webpackChunk||[]).push([["sas-custom-form"],{8234:(e,t,s)=>{var n=s(8254),d=s(6285);class a extends d.Z{init(){this._client=new n.Z,this.button=this.el.children["custom-form-ajax-button"],document.getElementById("custom_form").addEventListener("click",this._toggleAttribute),this._registerEvents()}_toggleAttribute(){const e=document.getElementById("firstName").value,t=document.getElementById("lastName").value,s=document.getElementById("company").value,n=document.getElementById("email").value;document.getElementById("custom-form-ajax-button").disabled=""===e||""===t||""===s||""===n}_registerEvents(){this.button.addEventListener("click",this._fetch.bind(this))}_fetch(e){const t=document.getElementById("firstName").value,s=document.getElementById("lastName").value,n=document.getElementById("phoneNumber").value,d=document.getElementById("company").value,a=document.getElementById("email").value,o=document.getElementById("country").value,m=document.getElementById("city").value,l=document.getElementById("postalCode").value,c=document.getElementById("streetNumber").value,u=document.getElementById("street").value,i=document.getElementById("description").value,r=document.getElementById("customFile");let g=new FormData,y=JSON.stringify({firstName:t,lastName:s,phoneNumber:n,company:d,email:a,country:o,city:m,postalCode:l,streetNumber:c,street:u,description:i});if(g.append("data",y),r.files[0]){let e=r.files[0];g.append("files",e,e.name)}e.preventDefault(),this._client.post("/sas/custom/form",g,this._setContent.bind(this),!1,!0)}_setContent(e){e=JSON.parse(e);const t=document.getElementById("alert-message-warning"),s=document.getElementById("alert-message-success");e.error?(s.classList.remove("d-block"),s.classList.add("d-none"),t.classList.remove("d-none"),t.classList.add("d-block"),t.classList.add("show"),t.appendChild(document.createTextNode(e.message))):(t.classList.remove("d-block"),t.classList.add("d-none"),s.classList.remove("d-none"),s.classList.add("show"),s.classList.add("d-block"),s.appendChild(document.createTextNode(e.message)),document.getElementById("custom-form-ajax-button").disabled=!0)}}window.PluginManager.register("SasCustomForm",a,"[data-sas-custom-form]")}},e=>{e.O(0,["vendor-node","vendor-shared"],(()=>{return t=8234,e(e.s=t);var t}));e.O()}]);