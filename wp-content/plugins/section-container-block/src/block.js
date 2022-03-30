const { RichText, MediaUpload, PlainText, InspectorControls, ColorPalette, InnerBlocks } = wp.editor;
const { registerBlockType } = wp.blocks;
const { PanelBody, Button, TextControl, SelectControl } = wp.components;
const { Fragment } = wp.element;

import './style.scss';
import './editor.scss';

registerBlockType('kne/section-container-block', {
  title: 'Section Container Block',
  icon: 'heart',
  category: 'common',
  attributes: {
    bgColor: {
      type: 'string',
      default: 'transparent'
    },
    bgImage: {
      type: 'object',
      default: null
    },
    containerId: {
      type: 'string',
      default: null
    },
    elementTag: {
      type: 'string',
      default: 'section'
    }
  },

  edit( {attributes, className, setAttributes} ) {

    const styles = {
      backgroundColor: attributes.bgColor
    }
    //if bgImage
    if(attributes.bgImage){
      styles.backgroundImage = 'url(' + attributes.bgImage.image.url + ')'
      styles.backgroundSize = 'cover'
    };

    const onSelectBgImage = ( media ) => {
  		setAttributes( {
  			bgImage: {
  				id: media.id,
  				image: media.sizes.large || media.sizes.full,
  			}
  		} )
  	}

  	const onRemoveBgImage = () => {
  		setAttributes( {
  			bgImage: null
  		} )
  	}

    const getImageButton = (openEvent) => {
      if(attributes.bgImage) {
        return [
          <Button
            onClick={ openEvent }
            className="button button-large"
          >
            Change image
          </Button>,
          <Button
            onClick={ onRemoveBgImage }
            className="button button-large"
          >
            Remove background image
          </Button>
        ];
      } else {
        return (
          <Button
            onClick={ openEvent }
            className="button button-large"
          >
            Choose background image
          </Button>
        );
      }
    };

    return(
      <Fragment>
        <InspectorControls>
          <PanelBody>
            <strong>Select a background color:</strong>
            <ColorPalette
              value={ attributes.bgColor }
              onChange={ color => setAttributes({ bgColor: color })}
            />
          </PanelBody>
          <PanelBody>
            <label><strong>Choose a background image for the section:</strong></label>
            <br />
            <MediaUpload
              onSelect={ onSelectBgImage }
              allowedTypes={["image"]}
              value={ attributes.bgImage }
              render={ ({ open }) => getImageButton(open) }
            />
          </PanelBody>
          <PanelBody>
            <TextControl
              label='Container ID'
              value={ attributes.containerId }
              onChange={ (value) => setAttributes({ containerId: value })}
            />
          </PanelBody>
          <PanelBody>
            <SelectControl
              onChange={(value) => setAttributes({ elementTag: value })}
              value={ attributes.elementTag }
              label={'Choose container type'}
              options={[ {value: 'section', label: 'section'}, {value: 'div', label: 'div'} ]}
            />
          </PanelBody>
        </InspectorControls>
        <div className="section-wrapper" style={styles}>
          <InnerBlocks />
        </div>
      </Fragment>
    )
  },


  save( { attributes } ) {

    const styles = {
      backgroundColor: attributes.bgColor
    };
    //if bgImage
    if(attributes.bgImage){
      styles.backgroundImage = 'url(' + attributes.bgImage.image.url + ')'
      styles.backgroundSize = 'cover'
    };

    //element type
    let container = <section style={styles} id={attributes.containerId}><InnerBlocks.Content /></section>;
    if( attributes.elementTag == 'div' ){
      container = <div style={styles} id={attributes.containerId}><InnerBlocks.Content /></div>;
    }

    return container;
    ;
  },

  deprecated: [
    {
      save ( { attributes } ) {
        //element type
        let container = <section id={attributes.containerId}><InnerBlocks.Content /></section>;
        if( attributes.elementTag == 'div' ){
          container = <div id={attributes.containerId}><InnerBlocks.Content /></div>;
        }
        return container;
      }
    }
  ]


});
