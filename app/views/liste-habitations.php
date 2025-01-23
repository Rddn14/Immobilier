import React from 'react';
import { Card } from '@/components/ui/card';
import { Heart } from 'lucide-react';

const HabitationListing = () => {
  // Simuler les données des habitations
  const habitations = [
    {
      id: 1,
      photos: ['/api/placeholder/400/300'],
      type: 'Villa',
      emplacement: 'Ivandry, Madagascar',
      loyer_journalier: 250000,
      note: 4.9,
      statut: 'Professionnel',
      description: 'Belle villa moderne avec piscine'
    },
    {
      id: 2,
      photos: ['/api/placeholder/400/300'],
      type: 'Appartement',
      emplacement: 'Ankorondrano, Madagascar',
      loyer_journalier: 150000,
      note: 4.7,
      statut: 'Particulier',
      description: 'Appartement lumineux centre ville'
    },
    {
      id: 3,
      photos: ['/api/placeholder/400/300'],
      type: 'Maison',
      emplacement: 'Ankadimbahoaka, Madagascar',
      loyer_journalier: 200000,
      note: 4.8,
      statut: 'Professionnel',
      description: 'Maison familiale avec jardin'
    },
  ];

  return (
    <div className="container mx-auto px-4">
      {/* Grid des habitations */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {habitations.map((habitation) => (
          <Card key={habitation.id} className="relative overflow-hidden group">
            {/* Image principale */}
            <div className="relative aspect-square">
              <img
                src={habitation.photos[0]}
                alt={habitation.description}
                className="w-full h-full object-cover rounded-t-lg"
              />
              {/* Bouton favori */}
              <button className="absolute top-3 right-3 p-2 rounded-full bg-white/80 hover:bg-white">
                <Heart className="w-5 h-5" />
              </button>
            </div>

            {/* Informations de l'habitation */}
            <div className="p-4">
              {/* Première ligne: Localisation et note */}
              <div className="flex justify-between items-start mb-2">
                <h3 className="font-semibold text-lg">{habitation.emplacement}</h3>
                <div className="flex items-center gap-1">
                  <span>★</span>
                  <span>{habitation.note}</span>
                </div>
              </div>

              {/* Type et statut */}
              <p className="text-gray-500 mb-1">{habitation.type} • {habitation.statut}</p>

              {/* Description courte */}
              <p className="text-gray-500 mb-2 line-clamp-2">{habitation.description}</p>

              {/* Prix */}
              <p className="font-semibold">
                {habitation.loyer_journalier.toLocaleString()} Ar
                <span className="font-normal text-gray-500"> par nuit</span>
              </p>
            </div>
          </Card>
        ))}
      </div>
    </div>
  );
};

export default HabitationListing;