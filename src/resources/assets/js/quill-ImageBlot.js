let BlockEmbed = Quill.import('blots/block/embed');
export default class ImageBlot extends BlockEmbed {
  static create(value) {
    let node = super.create();
    node.setAttribute('alt', value.alt);
    node.setAttribute('style', value.style);
    node.setAttribute('width', value.width);
    node.setAttribute('src', value.url);
    return node;
  }

  static value(node) {
    return {
      style: node.getAttribute('style'),
      alt: node.getAttribute('alt'),
      style: node.getAttribute('width'),
      url: node.getAttribute('src')
    };
  }
}
ImageBlot.blotName = 'image';
ImageBlot.tagName = 'img';

Quill.register(ImageBlot);