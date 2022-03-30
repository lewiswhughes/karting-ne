const { InnerBlocks } = wp.editor;
const { registerBlockType } = wp.blocks;

export default registerBlockType('kne/column-block', {
  title: 'Single Column Block',
  parent: 'kne/columns-block',
  icon: 'heart',
  category: 'common',


  edit() {
    return <InnerBlocks templateLock={ false } />;
  },


  save( ) {
    return <div><InnerBlocks.Content /></div>
  }


});
