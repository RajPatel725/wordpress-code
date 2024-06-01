import React from 'react'
// child
function Child(props) {
    return (
        <>
            <div className="product-card">
                <h2>{props.name}</h2>
                <p>{props.description}</p>
                <h3>$. {props.price}</h3>
            </div>
        </>
    )
}
export default Child