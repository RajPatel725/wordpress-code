import React from 'react';

class Studant extends React.Component {
    render() {
        return (
            <>
                <div className="product-card">
                    <h1>{this.props.name}</h1>
                </div>
            </>
        )
    }
}

export default Studant