const { __ } = wp.i18n; // Import __() from wp.i18n
const { InspectorControls  } = wp.editor;
const { registerBlockType } = wp.blocks;
const { SelectControl, PanelBody, TextareaControl } = wp.components;
const { Fragment } = wp.element;

registerBlockType('kne/svg-block', {
  title: 'SVG Block',
  icon: 'heart',
  category: 'common',
  attributes: {
    svgText: {
      default: '',
  		type: 'string'
    }
  },

  edit( { attributes, setAttributes, isSelected } ) {

    return(
      <Fragment>
        <div className="svg-container" dangerouslySetInnerHTML={ { __html: attributes.svgText } }></div>
        { isSelected && (
        <TextareaControl
          label="SVG Text:"
          placeholder="Enter or paste your SVG image text in here"
          help="Enter or paste your SVG image text in here"
          value={ attributes.svgText }
          onChange={ text => setAttributes({ svgText: text }) }
        />
        ) }
      </Fragment>
    )

  },


  save( { attributes } ) {
    return <div className="svg-container" dangerouslySetInnerHTML={ { __html: attributes.svgText } }></div>;
  }


});
