import React from 'react';

const Header = ({title, button1, button2}) => {
    return (
        <div className='header'>
            <h1>{ title }</h1>
            <div className='header--buttons'>
                <button>{ button1 }</button>
                <button>{ button2 }</button>
            </div>
        </div>
    );
};

export default Header;