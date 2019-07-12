class Caption { 
    constructor(quill, options) {
        this.quill = quill;
        this.options = options;
        this.toolbar = quill.getModule('toolbar');
        if (typeof this.toolbar !== 'undefined'){
            //name to use
            this.toolbar.addHandler('test-1', this.addOmega());
        }
    }
    
    addOmega() {
        let quill = this.quill;
        var customButton = document.querySelector('.ql-omega');
        customButton.addEventListener('click', function() {
        var range = this.quill.getSelection();
        if (range) {
            this.quill.insertText(range.index, "Ω");
        }});
      }
}

Quill.register('modules/caption', Caption);
