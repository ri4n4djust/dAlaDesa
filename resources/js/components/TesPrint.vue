<template>
<div id="tesp1">
    <p>tess print</p>
    <div ref="printContent"> this is content to print </div>
    <div> this is normal content </div>
    <Printer :content="content">
      <button>print</button>
    </Printer>
        <div id="tesp">
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
            <span>this is normal content</span><br>
        </div>
        <button @click="rePrint()">re-print</button>
        <button @click="print()">print</button>
        <button @click="buildMessage()">printer</button>
    </div>
</template>
<style>
#tesp { display: block; }

    @media print
    {
        
  body {
    visibility: hidden;
    height: 100%;
  }
  #tesp, #tesp * {
    visibility: visible;
    
  }
  #tesp {
    /* page-break-inside: none;   
    page-break-before: none; */
    /* page-break-after:initial;
    position: absolute;
    left: 3;
    top: 0;
    font-size: 8pt;
    width: 100%;
    height: 1024px; */
  }
}
</style>
<script>
// import epson from './plugins/epson/epos-2.20.0.js';
// import epson from './plugins/epson/epos-2.20.0.js';
import Vue from 'vue'
import Printer from '@eyelly/vue-printer'
Vue.component('Printer',Printer)

    export default {
        computed: {
            content() {
                return {
                refs: this.$refs,
                refName: 'printContent'
                }
            }
        },

        methods:{
            rePrint: function(){
                window.print(tesp);
            },
            print() {
                var prtContent = document.getElementById("print");
                var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
                WinPrint.document.write(prtContent.innerHTML);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
                WinPrint.close();
            },
            buildMessage() {
                var ipAddress = 'http://192.168.1.65';
                var port      = ':8008';
                var deviceID_printer = 'local_printer';
             //Create an ePOS-Print Builder object
             var builder = new epson.ePOSBuilder();
             //Create a print document
             builder.addTextLang('en');
             builder.addTextSmooth(true);
             builder.addTextFont(builder.FONT_A);
             builder.addTextSize(3, 3);
             builder.addText('Hello,\tWorld!\n');
             builder.addCut(builder.CUT_FEED);
             //Acquire the print document
             var request = builder.toString();
             var address = ipAddress+port+'/cgi-bin/epos/service.cgi?devid'+deviceID_printer+'=&timeout=1000';
             //Create an ePOS-Print object
             var epos = new epson.ePOSPrint(address);
             epos.onreceive = function (res) {
             //When the printing is not successful, display a message
             if (!res.success) {
                alert('A print error occurred');
                }
             }
             //Send the print document
             epos.send(request);
         }
           
        }

    }
    // src="epos-2.17.0.js"
</script>