/**
 * Playground application handling.
 */
window.playground = {
    /**
     * Form handling for Playground.
     */
    forms: {
        /**
         * Enable editors on forms.
         */
        editor: function(selector) {
            selector = '' == selector ? '.editor' : selector;
            // console.debug('playground.forms.editor', {
            //     selector: selector
            // })
            ClassicEditor.create(document.querySelector(selector)).catch(error => {
                console.error(error);
            });
            // .then(editorInstance => {
            //     console.debug('playground.forms.editor', {
            //         editorInstance: editorInstance
            //     })
            //     editorInstance.ui.focusTracker.on('change:isFocused', (evt, name, isFocused) => {
            //         console.debug('playground.forms.editor', {
            //             evt: evt,
            //             name: name,
            //             isFocused: isFocused,
            //         })
            //         if (!isFocused) {
            //             editorInstance.updateSourceElement();
            //         }
            //     });
            // });
        },
        /**
         * Enable form validation.
         */
        validation: function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // console.debug('playground.forms.validation', {
            //     forms: forms
            // });
            // Loop over them and prevent submission
            Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }
    }
}
