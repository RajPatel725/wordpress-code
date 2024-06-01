import axios from 'axios';
import React, { useEffect, useState } from 'react'
import { Container, Row } from 'react-bootstrap'

function ScrollLoadMore() {

  let currentOffset = 0;
  const [pokemon, setPokemon] = useState([]);

  const loadTenPokemon = () => {
    const tenPokemon = [];
    axios
      .get(`https://pokeapi.co/api/v2/pokemon?limit=10&offset=${currentOffset}`)
      .then(({ data }) => {
        data.results.forEach((p) => tenPokemon.push(p.name));
        setPokemon((pokemon) => [...pokemon, ...tenPokemon]);
      });
    currentOffset += 10;
  };

  const handleScroll = (e) => {
    // console.log(e.target.documentElement.scrollTop);
    // console.log(window.innerHeight);
    // console.log(e.target.documentElement.scrollHeight);
    
    const scrollHeight = e.target.documentElement.scrollHeight;
    const currentHeight = Math.ceil(e.target.documentElement.scrollTop + window.innerHeight);

    if (currentHeight + 1 >= scrollHeight) {
      loadTenPokemon();
    }
  };

  useEffect(() => {
    loadTenPokemon();
    window.addEventListener("scroll", handleScroll);
  }, []);

  return (
    <Container>
      <Row>
        <h2>On Scroll LoadMore</h2>
        {pokemon.map((p, i) => {
          return (
            <div
              key={i}
              className="border border-secondary p-3"
            >
              <div>{i + 1}. {p}</div>
            </div>
          );
        })}
      </Row>
    </Container>
  )
}

export default ScrollLoadMore
