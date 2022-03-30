const { RichText, MediaUpload, PlainText, InspectorControls, ColorPalette } = wp.editor;
const { registerBlockType } = wp.blocks;
const { Button } = wp.components;

import './style.scss';
import './editor.scss';

registerBlockType('kne/splash-block', {
  title: 'Splash Block',
  icon: 'heart',
  category: 'common',
  attributes: {
    header: {
      type: 'text',
      source: 'text',
      selector: 'h1'
    },
    fontColor: {
      type: 'string',
      default: 'black'
    },
    subheader: {
      type: 'text',
      source: 'text',
      selector: 'p.subheader'
    },
    imageAlt: {
      attribute: 'alt',
      selector: 'img'
    },
    imageUrl: {
      attribute: 'src',
      selector: 'img'
    }
  },

  edit( {attributes, className, setAttributes} ) {

    const getImageSource = () => {
      if(attributes.imageUrl) {
        return(
          attributes.imageUrl
        );
      } else {
        return 'https://source.unsplash.com/random'
      }
    }

    const getImageButton = (openEvent) => {
      if(attributes.imageUrl) {
        return (
          <Button
            onClick={ openEvent }
            className="button button-large"
          >
            Change image
          </Button>
        );
      } else {
        return (
          <Button
            onClick={ openEvent }
            className="button button-large"
          >
            Choose splash image
          </Button>
        );
      }
    };

    return[
      <InspectorControls>
        <div>
          <strong>Select a font color:</strong>
          <ColorPalette
            value={ attributes.fontColor }
            onChange={ color => setAttributes({ fontColor: color })}
          />
        </div>
      </InspectorControls>,
      <div className="container">
        <img
          src={ getImageSource() }
          className="image"
        />
        <PlainText
          onChange={ content => setAttributes({ header: content }) }
          value={ attributes.header }
          placeholder="Header text"
          className="header"
          style={{color: attributes.fontColor }}
        />
        <PlainText
          onChange={ content => setAttributes({ subheader: content }) }
          value={ attributes.subheader }
          placeholder="Subheader text"
          className="subheader"
          style={{color: attributes.fontColor }}
        />
        <MediaUpload
          onSelect={ media => { setAttributes({ imageAlt: media.alt, imageUrl: media.url }); } }
          type="image"
          value={ attributes.imageID }
          render={ ({ open }) => getImageButton(open) }
        />
      </div>
    ]
  },


  save( { attributes } ) {

    const splashImage = (src, alt) => {
      if(!src) return null;

      if(alt) {
        return (
          <img
            src={ src }
            alt={ alt }
          />
        );
      }
      // No alt set, so let's hide it from screen readers
      return (
        <img
          src={ src }
          alt=""
          aria-hidden="true"
        />
      );
    };

    return (
      <section className="splash">
        { splashImage(attributes.imageUrl, attributes.imageAlt) }
        <h1 style={{ color: attributes.fontColor }}>{ attributes.header }</h1>
        <p className="subheader" style={{ color: attributes.fontColor }}>
          { attributes.subheader }
        </p>
      </section>
    );
  }


});
