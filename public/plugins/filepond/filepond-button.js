/*!
 * FilePondPluginButton 
 * Licensed under MIT, https://opensource.org/licenses/MIT/
 * Please visit undefined for details.
 */
/* eslint-disable */
(function (global, factory) {
   typeof exports === 'object' && typeof module !== 'undefined' ?
      (module.exports = factory()) :
      typeof define === 'function' && define.amd ?
         define(factory) :
         ((global =
            typeof globalThis !== 'undefined' ? globalThis : global || self),
            (global.FilePondPluginButton = factory()));
})(this, function () {
   'use strict';
   /**
    * Register the download component by inserting the download icon
    */
   const registerDownloadComponent = (
      item,
      el,
      labelButtonDownload,
      allowDownloadByUrl
   ) => {
    
      
         if((typeof item.source) === 'string'){
            const info = el.querySelector('.filepond--file-info-main'),
            downloadIcon = getDownloadIcon(labelButtonDownload);
         info.prepend(downloadIcon);
         downloadIcon.addEventListener('click', () =>
            previewFile(item, allowDownloadByUrl)
         );
   
   
         const info2 = el.querySelector('.filepond--file-info-main'),
         getDownloadBUtton = getDownloadButton(labelButtonDownload);
         info2.prepend(getDownloadBUtton);
         getDownloadBUtton.addEventListener('click', () =>
         downloadFile2(item, allowDownloadByUrl)
         );
         }
       
   };
   /**
    * Generates the download icon
    */
   const getDownloadIcon = (labelButtonDownload) => {
      let icon = document.createElement('span');
      icon.className = ' lianm btn btn-sm btn-primary';
      icon.innerHTML = 'Lihat';
      icon.title = labelButtonDownload;
      return icon;
   };

   const getDownloadButton = (labelButtonDownload) => {
      let icon = document.createElement('span');
      icon.className = 'btn-success btn btn-sm lianm2';
      icon.innerHTML = '<i class="fas fa-arrow-down"></i>';

      icon.title = labelButtonDownload;
      return icon;
    };
   /**
    * Triggers the actual download of the uploaded file
    */
   const previewFile = (item, allowDownloadByUrl) => {
      // if client want to download file from remote server
      // create a temporary hyperlink to force the browser to download the file
      const a = document.createElement('a');
      const url = window.URL.createObjectURL(item.file);
      console.log(item)
      openCenteredWindow(item.source)
      document.body.appendChild(a);
      a.style.display = 'none';
      a.href = url;
      a.download = item.file.name;
      //  a.click();
      window.URL.revokeObjectURL(url);
      a.remove();
   };



   const downloadFile2 = (item, allowDownloadByUrl) => {
      // if client want to download file from remote server
      if (allowDownloadByUrl && item.getMetadata('url')) {
        location.href = item.getMetadata('url'); // full path to remote server is stored in metadata with key 'url'
      } else {
        // create a temporary hyperlink to force the browser to download the file
        const a = document.createElement('a');
        const url = window.URL.createObjectURL(item.file);
        document.body.appendChild(a);
        a.style.display = 'none';
        a.href = url;
        a.download = item.file.name;
        a.click();
        window.URL.revokeObjectURL(url);
        a.remove();
      }
    };


   function openCenteredWindow(url) {
      const width = 800
      const height = 700
      const pos = {
         x: (screen.width / 2) - (width / 2),
         y: (screen.height / 2) - (height / 2)
      };
      const features = `width=${width} height=${height} left=${pos.x} top=${pos.y}`;
      return window.open(url, '_blank', features).focus();
   }
   /**
    * Download Plugin
    */
   const plugin = (fpAPI) => {
      const {
         addFilter,
         utils
      } = fpAPI;
      const {
         Type,
         createRoute
      } = utils; // called for each view that is created right after the 'create' method
      addFilter('CREATE_VIEW', (viewAPI) => {
         // get reference to created view
         const {
            is,
            view,
            query
         } = viewAPI; // only hook up to item view
         if (!is('file')) {
            return;
         } // create the get file plugin
         const didLoadItem = ({
            root,
            props
         }) => {
            const {
               id
            } = props;
            const item = query('GET_ITEM', id);
            if (!item || item.archived) {
               return;
            }
            const labelButtonDownload = root.query(
               'GET_LABEL_BUTTON_DOWNLOAD_ITEM'
            );
            const allowDownloadByUrl = root.query('GET_ALLOW_DOWNLOAD_BY_URL');
            registerDownloadComponent(
               item,
               root.element,
               labelButtonDownload,
               allowDownloadByUrl
            );
         }; // start writing
         view.registerWriter(
            createRoute({
               DID_LOAD_ITEM: didLoadItem,
            },
               ({
                  root,
                  props
               }) => {
                  const {
                     id
                  } = props;
                  const item = query('GET_ITEM', id); // don't do anything while hidden
                  if (root.rect.element.hidden) return;
               }
            )
         );
      }); // expose plugin
      return {
         options: {
            labelButtonDownloadItem: ['', Type.STRING],
            allowDownloadByUrl: [false, Type.BOOLEAN],
         },
      };
   }; // fire pluginloaded event if running in browser, this allows registering the plugin when using async script tags
   const isBrowser =
      typeof window !== 'undefined' && typeof window.document !== 'undefined';
   if (isBrowser) {
      document.dispatchEvent(
         new CustomEvent('FilePond:pluginloaded', {
            detail: plugin,
         })
      );
   }
   return plugin;
});
