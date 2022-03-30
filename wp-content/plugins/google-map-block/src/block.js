const { InspectorControls} = wp.editor;
const { registerBlockType } = wp.blocks;
const { PanelBody, SelectControl, TextControl, RangeControl } = wp.components;
const { Fragment } = wp.element;
const { withSelect } = wp.data;

import './style.scss';
import './editor.scss';

registerBlockType('kne/google-map-block', {
  title: 'Google Map Block',
  icon: 'heart',
  category: 'common',
  attributes: {
    latitude: {
			type: "float",
			default: 54.4342,
		},
		longitude: {
			type: "float",
			default: -3.0377,
		},
		zoom: {
			type: "integer",
			default: 18,
		}
  },

  edit({ attributes, setAttributes }) {
      return [
          <InspectorControls>
            <PanelBody>
              <TextControl
                label="Latitude"
                value={ attributes.latitude }
                onChange={ value => setAttributes({ latitude: value }) }
              />
              <TextControl
                label="Longitude"
                value={ attributes.longitude }
                onChange={ value => setAttributes({ longitude: value }) }
              />
            </PanelBody>
            <PanelBody>
              <RangeControl
                label="Default Zoom Level"
                value={ attributes.zoom }
                onChange={ value => setAttributes({ zoom: value }) }
                min={ 1 }
                max={ 20 }
              />
            </PanelBody>
          </InspectorControls>,
          <div>Google Map Container</div>
        ]
  },

  save( { attributes } ) {
    return null
  },


});
