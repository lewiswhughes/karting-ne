const { PlainText, InspectorControls, InnerBlocks } = wp.editor;
const { PanelBody, RangeControl } = wp.components;
const { registerBlockType } = wp.blocks;
const { Fragment } = wp.element;

//import column-block
import './column.js';

import './style.scss';
import './editor.scss';

const ALLOWED_BLOCKS = [ 'kne/column-block' ];

const getColumnsTemplate = (numCols) => {
  let els = [];
  for( let x = 0; x<numCols; x++ ){
    els.push([ 'kne/column-block' ])
  }
  return els;
}

registerBlockType('kne/columns-block', {
  title: 'Columns Block',
  icon: 'heart',
  category: 'layout',
  attributes: {
    numCols: {
      type: 'text',
      default: '2'
    }
  },
  supports: {
		align: [ 'wide', 'full' ],
		html: false,
	},

  edit( {attributes, className, setAttributes} ) {

    const { numCols } = attributes;
    const classes = 'columns-wrapper columns-' + numCols;

    return[
      <InspectorControls>
        <PanelBody>
          <div>
            <strong>Select number of columns:</strong>
            <RangeControl
  						label="columns"
  						value={ attributes.numCols }
  						onChange={ ( nextColumns ) => {
  							setAttributes( {
  								numCols: nextColumns,
  							} );
  						} }
  						min={ 2 }
  						max={ 4 }
  					/>
          </div>
        </PanelBody>
      </InspectorControls>,
      <section className={classes}>
        <InnerBlocks
          template={ getColumnsTemplate( numCols ) }
          templateLock="all"
          allowedBlocks={ ALLOWED_BLOCKS } />
      </section>
    ];
  },


  save( { attributes } ) {

    const { numCols } = attributes;
    const classes = 'columns columns-' + numCols;

    return (
      <section className="columns">
        <InnerBlocks.Content />
      </section>
    );
  }


});
