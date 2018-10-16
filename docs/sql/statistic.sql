-- Nombre de passages passant ce créneau
select count(immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS');

-- Nombre de passages non discriminés durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = -1;

-- Nombre de passages de voitures durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de passages de camions durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules différents passant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS');

-- Nombre de véhicules différents non discriminés durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = -1;

-- Nombre de voitures différentes durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de camions différents durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules passés plusieurs fois durant ce créneau
select distinct immatriculation, count(*) from data.te_passage
where
  created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(*) > 1;

-- Nombre de véhicules vu dans les trois cases (VL,PL,Inconnu)
select distinct immatriculation, count(distinct l) from data.te_passage
where
  created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(distinct l) > 2;

-- Nombre de véhicules vu comme voitures et camions
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> -1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme voitures et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme camions et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 0
group by immatriculation
having count(distinct l) > 1;

--------------------------------------------------------
-- Nombre de passages passant ce créneau de nuit
select count(immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
;

-- Nombre de passages non discriminés durant ce créneau
select count(immatriculation) from data.te_passage
where
  (     created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  )
  and l = -1;

-- Nombre de passages de voitures durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de passages de camions durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules différents passant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS');

-- Nombre de véhicules différents non discriminés durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l = -1;

-- Nombre de voitures différentes durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de camions différents durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules passés plusieurs fois durant ce créneau
select distinct immatriculation, count(*) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(*) > 1;

-- Nombre de véhicules vu dans les trois cases (VL,PL,Inconnu)
select distinct immatriculation, count(distinct l) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(distinct l) > 2;

-- Nombre de véhicules vu comme voitures et camions
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> -1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme voitures et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme camions et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-16 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 23:59:59', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 07:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 16:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 23:59:59', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 0
group by immatriculation
having count(distinct l) > 1;

--------------------------------------------------------
-- Nombre de passages passant ce créneau de nuit
select count(immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
;

-- Nombre de passages non discriminés durant ce créneau
select count(immatriculation) from data.te_passage
where
  (     created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  )
  and l = -1;

-- Nombre de passages de voitures durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de passages de camions durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules différents passant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS');

-- Nombre de véhicules différents non discriminés durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = -1;

-- Nombre de voitures différentes durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de camions différents durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules passés plusieurs fois durant ce créneau
select distinct immatriculation, count(*) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(*) > 1;

-- Nombre de véhicules vu dans les trois cases (VL,PL,Inconnu)
select distinct immatriculation, count(distinct l) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(distinct l) > 2;

-- Nombre de véhicules vu comme voitures et camions
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> -1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme voitures et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme camions et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 01:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 01:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 0
group by immatriculation
having count(distinct l) > 1;





--------------------------------------------------------
-- Nombre de passages passant ce créneau de nuit
select count(immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
;

-- Nombre de passages non discriminés durant ce créneau
select count(immatriculation) from data.te_passage
where
  (     created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
        or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  )
  and l = -1;

-- Nombre de passages de voitures durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de passages de camions durant ce créneau
select count(immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules différents passant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS');

-- Nombre de véhicules différents non discriminés durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = -1;

-- Nombre de voitures différentes durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 0;

-- Nombre de camions différents durant ce créneau
select count(distinct immatriculation) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l = 1;

-- Nombre de véhicules passés plusieurs fois durant ce créneau
select distinct immatriculation, count(*) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(*) > 1;

-- Nombre de véhicules vu dans les trois cases (VL,PL,Inconnu)
select distinct immatriculation, count(distinct l) from data.te_passage
where
  created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
  or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
group by immatriculation
having count(distinct l) > 2;

-- Nombre de véhicules vu comme voitures et camions
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> -1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme voitures et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 1
group by immatriculation
having count(distinct l) > 1;

-- Nombre de véhicules vu comme camions et inconnu
select distinct immatriculation, count(distinct l) from data.te_passage
where
  (created between to_timestamp('2018-04-16 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-16 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-12 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-12 03:00:00', 'YYYY-MM-DD HH24:MI:SS')
   or created between to_timestamp('2018-04-13 00:00:00', 'YYYY-MM-DD HH24:MI:SS') and to_timestamp('2018-04-13 03:00:00', 'YYYY-MM-DD HH24:MI:SS'))
  and l <> 0
group by immatriculation
having count(distinct l) > 1;

